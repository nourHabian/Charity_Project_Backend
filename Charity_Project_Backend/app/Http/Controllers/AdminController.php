<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Charity;
use App\Models\Donation;
use App\Models\Notification;
use App\Models\Project;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        }

        $token = $admin->createToken('admin_token')->plainTextToken;

        return response()->json([
            'message' => 'Admin login successful',
            'admin'   => $admin,
            'token'   => $token,
        ]);
    }

    public function monthlyDonations()
    {
        // اذا اليوم اول الشهر بس كمان لازم شيك انو اخر مرة سحبت من العالم كان الشهر الماضي
        if (Carbon::now()->day === 1) {
            $users = User::where('monthly_donation', '!=', 0)->get();
            $charity = Charity::findOrFail(1);
            if ($charity->last_monthly_donation != null && Carbon::today()->isSameDay($charity->last_monthly_donation)) {
                return response()->json(['message' => 'you did monthly donation this month'], 200);
            }
            $charity->last_monthly_donation = Carbon::today();
            foreach ($users as $user) {
                if ($user->monthly_donation <= $user->balance) {
                    // edit balance and get points
                    $user->balance -= $user->monthly_donation;
                    $user->points += floor(5 * log(1 + $user->monthly_donation));
                    $user->save();

                    // notification that the monthly donation is done
                    $notification = [
                        'user_id' => $user->id,
                        'title' => 'التبرع الشهري',
                        'message' => 'تم تنفيذ التبرع الشهري بنجاح، نشكرك على التزامك المستمر بالعطاء'
                    ];
                    Notification::create($notification);

                    // add to donation history
                    $history = [
                        'user_id' => $user->id,
                        'type' => 'monthly_donation',
                        'amount' => $user->monthly_donation,
                    ];
                    Donation::create($history);

                    // add money to somewhere

                    $donation_type = $user->monthly_donation_type;
                    $balanceMap = [
                        'صحي' => 'health_projects_balance',
                        'تعليمي' => 'educational_projects_balance',
                        'سكني' => 'housing_projects_balance',
                        'غذائي' => 'nutritional_projects_balance',
                        'ديني' => 'religious_projects_balance',
                    ];

                    if (!isset($balanceMap[$donation_type])) {
                        return response()->json(['message' => 'error has occurred'], 400);
                    }
                    $column = $balanceMap[$donation_type];
                    $charity->$column += $user->monthly_donation;

                    $charity->number_of_donations++;
                    $charity->save();
                } else {
                    // notification that he doesn't have enough money
                    $notification = [
                        'user_id' => $user->id,
                        'title' => 'التبرع الشهري',
                        'message' => 'تعذر تنفيذ التبرع الشهري لهذا الشهر بسبب عدم توافر رصيد كافي في محفظتك. يرجى إعادة الشحن لضمان استمرارية الدعم.'
                    ];
                    Notification::create($notification);
                }
            }
            $users = User::where('monthly_donation', 0)
                ->where('role', '!=', 'مستفيد')
                ->get();
            foreach ($users as $user) {
                // send notification to try monthly donation
                $notification = [
                    'user_id' => $user->id,
                    'title' => 'التبرع الشهري',
                    'message' => 'فعّل ميزة التبرع الشهري واجعل عطاءك مستمراً، في حال التفعيل سيتم سحب المبلغ الذي تحدده تلقائياً من محفظتك مع بداية كل شهر لدعم المحتاجين، بادر بتفعيلها الآن!'
                ];
                Notification::create($notification);
            }
            return response()->json(['message' => 'monthly donation has been payed for users who activated it, and notifications has been sent to users who did not activate it yet'], 200);
        }
        return response()->json(['message' => 'today is not the first of the month'], 400);
    }

    public function donateToProject(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $validate = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
        $id = $request->id;
        $amount = $request->amount;
        $project = Project::findOrFail($id);
        $charity = Charity::findOrFail(1);

        if ($project->status !== 'جاري' || $project->duration_type === 'دائم') {
            return response()->json(['message' => 'لا يمكن التبرع لهذا المشروع'], 400);
        }
        $project_type = $project->type->name;

        $type_map = [
            'صحي' => 'health_projects_balance',
            'تعليمي' => 'educational_projects_balance',
            'سكني' => 'housing_projects_balance',
            'غذائي' => 'nutritional_projects_balance',
            'ديني' => 'religious_projects_balance',
        ];

        if (!isset($type_map[$project_type])) {
            return response()->json(['message' => 'نوع المشروع خاطئ'], 400);
        }

        $column = $type_map[$project_type];

        if ($amount > $charity->$column) {
            return response()->json(['message' => 'ليس لديك رصيد كافٍ لإتمام هذه العملية، الرجاء شحن المحفظة وإعادة المحاولة.'], 400);
        }

        $remaining = $project->total_amount - $project->current_amount;
        $charity->$column -= min($amount, $remaining);
        $charity->save();
    
        $project->current_amount = min($project->current_amount + $amount, $project->total_amount);
        // check if project is completed
        if ($project->current_amount == $project->total_amount) {
            $project->status = 'منتهي';

            // if this project belongs to a beneficiary
            if ($project->duration_type === 'فردي') {
                $beneficiary = $project->user;
                // send notification to the beneficiary that his project has finished
                $notification = [
                    'user_id' => $beneficiary->id,
                    'title' => 'تم تمويل حالتك بالكامل',
                    'message' => 'تم تغطية حالتك بالكامل، وسيتم التواصل معك بأقرب وقت لتوصيل التبرعات، نسأل الله أن ييسر لك الأمور ويجزي المتبرعين خيراً.'
                ];
                Notification::create($notification);
            }

            // send notifications to all participated donors in this project
            $donors = $project->donations()->with('user')->get()->pluck('user')->unique('id');
            foreach ($donors as $donor) {
                $donor = User::findOrFail($donor->id);
                $notification = [
                    'user_id' => $donor->id,
                    'title' => 'تطورات جديدة في مشروع ' . $project->name,
                    'message' => 'بفضل الله ثم بفضلك وبفضل باقي المتبرعين، تم إتمام ' . $project->name . 'بالكامل، شكراً لدعمك المستمر🙏🏻',
                ];
                Notification::create($notification);
            }
        }
        $project->save();
        return response()->json(['message' => 'تم التبرع لهذا المشروع بنجاح وسحب مبلغ ' . min($amount, $remaining) . '$ من رصيد الجمعية'], 200);
    }
}
