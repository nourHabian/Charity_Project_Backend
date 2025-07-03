<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Mail\PinCodeMail;
use App\Models\Charity;
use App\Models\Donation;
use App\Models\Notification;
use App\Models\Project;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $verification_code = random_int(1000, 9999);

        $exists = User::where('phone_number', $request->phone_number)
            ->where('email', $request->email)->exists();

        $user = null;
        if (!$exists) {
            $validate = $request->validate([
                'full_name' => 'required|string|max:40',
                'phone_number' => 'required|string|min:6|max:10|unique:users,phone_number',
                'email' => 'required|string|email|unique:users,email|max:40',
                'password' => 'required|string|min:5|confirmed'
            ]);

            $user = User::create([
                'full_name' => $request->full_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'verification_code' => $verification_code,
            ]);
        } else {
            $existed_user = User::where('phone_number', $request->phone_number)
                ->where('email', $request->email)->firstOrFail();
            if ($existed_user->verified) {
                $request->validate([
                    'full_name' => 'required|string|max:40',
                    'phone_number' => 'required|string|min:6|max:10|unique:users,phone_number',
                    'email' => 'required|string|email|unique:users,email|max:40',
                    'password' => 'required|string|min:5|confirmed'
                ]);
            }
            $validate = $request->validate([
                'full_name' => 'required|string|max:40',
                'password' => 'required|string|min:5|confirmed'
            ]);

            $existed_user->update([
                'full_name' => $request->full_name,
                'password' => Hash::make($request->password),
                'verification_code' => $verification_code,
            ]);
            $user = $existed_user;
        }

        Mail::to($user->email)->send(new PinCodeMail($user, $verification_code));
        return response()->json(['message' => 'User Registered Successfully', 'user' => $user], 200);
    }

    public function verify_email(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        if ($request->verification_code == $user->verification_code) {
            $user->update([
                'verified' => true,
            ]);
            return response()->json(['message' => 'تم التحقق من البريد الإلكتروني بنجاح'], 200);
        } else {
            return response()->json(['message' => 'رمز التحقق غير صحيح، يرجى المحاولة مرة أخرى'], 401);
        }
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string'
        ]);
        if (!Auth::attempt($request->only('email', 'password')))
            return response()->json(['message' => 'invalid password or email'], 401);

        $user = User::where('email', $request->email)->firstOrFail();
        if (!$user->verified) {
            return response()->json(['message' => 'invalid password or email'], 401);
        }
        $token = $user->createToken('auth_Token')->plainTextToken;

        $unreadCount = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $token, 'unread_count' => $unreadCount], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout successful']);
    }

    public function editPassword(Request $request)
    {
        $validate = $request->validate([
            'new_password' => 'required|string|min:6|max:10|confirmed',
        ]);

        $user = Auth::user();

        // تحديث كلمة المرور بشكل صحيح
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json(['message' => 'password has been changed successfully'], 200);
    }

    public function GetUserInformation()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id)
            ->where('is_read', false)->get();
        return response()->json([
            'user' => $user,
            'number of unread notifications' => count($notifications)
        ], 200);
    }

    public function addToBalance(Request $request)
    {
        $validate = $request->validate([
            'card_number' => 'required|digits:4',
            'amount' => 'required|numeric|min:0.1'
        ]);
        $user = Auth::user();
        $user->balance += $request->amount;
        $user->save();
        return response()->json($user, 200);
    }

    public function giveGift(Request $request)
    {
        $validate = $request->validate([
            'phone_number' => 'required|string|min:6|max:10',
            'beneficiary_name' => 'required|string|max:40',
            'amount' => 'required|numeric|min:1'
        ]);
        $user = Auth::user();
        // search the beneficiary
        $beneficiary = User::where('phone_number', $request->phone_number)->first();
        // check if this user does exist and is a beneficiary
        if ($beneficiary && $beneficiary->role == 'مستفيد') {
            // check if there's enough money in wallet
            if ($request->amount > $user->balance) {
                return response()->json(['message' => 'لا يوجد لديك رصيد كافي للقيام بهذه العملية، الرجاء شحن المحفظة والمحاولة مرة أخرى'], 422);
            }

            // edit donor's balance
            $user->balance -= $request->amount;
            $user->save();


            // send beneficiary a notification
            $beneficiary_notification = [
                'user_id' => $beneficiary->id,
                'title' => 'تم توصيل هدية إليك',
                'message' => 'تم توصيل هدية إليك من أحد المتبرعين بمبلغ ' . $request->amount . ' نأمل أن تكون سبباً في رسم البسمة على وجهك.'
            ];
            $donor_notification = [
                'user_id' => $user->id,
                'title' => 'تم إرسال الهدية بنجاح',
                'message' => 'تم إرسال هديتك بنجاح إلى ' . $request->beneficiary_name . '، جزاك الله خيراً🙏🏻'
            ];
            Notification::create($beneficiary_notification);
            Notification::create($donor_notification);

            // add this to donor's donation history
            $history = [
                'user_id' => $user->id,
                'type' => 'gift',
                'amount' => $request->amount,
                'recipient_number' => $request->phone_number
            ];
            Donation::create($history);

            // add one to number of donations
            $charity = Charity::findOrFail(1);
            $charity->number_of_donations++;
            $charity->save();
            return response()->json(['message' => 'تم الإهداء بنجاح، شكراً لك!'], 200);
        } else {
            return response()->json(['message' => 'لقد حدث خطأ! يبدو أن هذا المحتاج غير مسجل لدينا في التطبيق، يمكنك دعوته للتسجيل على صفحة الويب الخاصة بنا'], 404);
        }
    }

    public function giveZakat(Request $request)
    {
        $validate = $request->validate([
            'amount' => 'required|numeric|min:1',
            'type' => 'required|string'
        ]);
        $user = Auth::user();
        if ($user->balance < $request->amount) {
            return response()->json(['message' => 'لا يوجد لديك رصيد كافي للقيام بهذه العملية، الرجاء شحن المحفظة والمحاولة مرة أخرى'], 422);
        }
        $user->balance -= $request->amount;
        $user->save();
        // send notification
        $notification = [
            'user_id' => $user->id,
            'title' => 'تم استلام زكاتك',
            'message' => 'تم استلام زكاتك وسيتم إيصالها إلى مستحقيها في أقرب وقت ممكن، جزاك الله خيراً🙏🏻. '
        ];
        Notification::create($notification);

        // add to donation history
        $history = [
            'user_id' => $user->id,
            'type' => 'zakat',
            'amount' => $request->amount,
        ];
        Donation::create($history);

        // give points
        $user->points += floor(5 * log(1 + $request->amount));
        $user->save();

        // add money to somewhere
        $charity = Charity::findOrFail(1);
        if ($request->type == 'صحي') {
            $charity->health_projects_balance += $request->amount;
        } else if ($request->type == 'تعليمي') {
            $charity->educational_projects_balance += $request->amount;
        } else if ($request->type == 'سكني') {
            $charity->housing_projects_balance += $request->amount;
        } else if ($request->type == 'غذائي') {
            $charity->nutritional_projects_balance += $request->amount;
        } else {
            return response()->json(['message' => 'error has occurred'], 401);
        }

        $charity->number_of_donations++;
        $charity->save();
        return response()->json(['message' => 'تم استلام الزكاة بنجاح'], 200);
    }

    public function donateToProject($id, Request $request)
    {
        $validate = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
        $amount = $request->amount;
        $project = Project::findOrFail($id);

        $user = Auth::User();
        if ($amount > $user->balance) {
            return response()->json(['message' => 'ليس لديك رصيد كافٍ لإتمام هذه العملية، الرجاء شحن المحفظة وإعادة المحاولة.'], 401);
        }
        $user->balance -= $amount;
        $user->points += floor(5 * log(1 + $amount));
        $user->save();

        // add to donation history
        $remaining = $project->total_amount - $project->current_amount;
        $history = [
            'user_id' => $user->id,
            'project_id' => $project->id,
            'type' => 'project_donation',
            'amount' => min($amount, $remaining),
        ];
        Donation::create($history);

        // add money and check if it's completed and if donation is bigger than required
        if ($project->duration_type === 'دائم') {
            return response()->json(['message' => 'تم استلام تبرعك بنجاح، جزاك الله خيراً.'], 200);
        }
        $project->current_amount = min($project->current_amount + $amount, $project->total_amount);
        // check if project is completed
        if ($remaining <= $amount) {
            // check if donor donated more than the project need to finish
            if ($remaining < $amount) {
                $user->balance += $amount - $remaining;
                $user->save();
            }
            // change project status to finished
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
        return response()->json(['message' => 'تم استلام تبرعك بنجاح، جزاك الله خيراً'], 200);
    }

    public function monthlyDonation(Request $request)
    {
        $validate = $request->validate([
            'amount' => 'required|numeric|min:1',
            'type' => 'required|string'
        ]);
        $user = Auth::User();
        $pre_donation = $user->monthly_donation;
        $user->update([
            'monthly_donation' => $request->amount,
            'monthly_donation_type' => $request->type
        ]);
        if ($pre_donation == 0) {
            $notification = [
                'user_id' => $user->id,
                'title' => 'التبرع الشهري',
                'message' => 'تم تفعيل خاصية التبرع الشهري بنجاح، سيتم اقتطاع ' . $request->amount . '$ من محفظتك في بداية كل شهر، جزاك الله خيراً🙏🏻'
            ];
            Notification::create($notification);
            return response()->json(['message' => 'تم تفعيل التبرع الشهري بنجاح'], 200);
        } else {
            $notification = [
                'user_id' => $user->id,
                'title' => 'التبرع الشهري',
                'message' => 'تم التعديل على خاصية التبرع الشهري بنجاح، سيتم اقتطاع ' . $request->amount . '$ من محفظتك في بداية كل شهر، جزاك الله خيراً🙏🏻'
            ];
            Notification::create($notification);
            return response()->json(['message' => 'تم التعديل على خاصية التبرع الشهري بنجاح'], 200);
        }
    }

    public function cancelMonthlyDonation()
    {
        $user = Auth::User();
        if ($user->monthly_donation == 0) {
            return response()->json(['message' => 'الميزة غير مفعلة حالياً'], 200);
        }
        $user->update([
            'monthly_donation' => 0,
        ]);
        $notification = [
            'user_id' => $user->id,
            'title' => 'التبرع الشهري',
            'message' => 'تم إلغاء ميزة التبرع الشهري بنجاح، يمكنك إعادة تفعيل الميزة في أي وقت ليبقى خيرك مستمراً ويصل عطاؤك لمن يستحق🙏🏻'
        ];
        Notification::create($notification);
        return response()->json(['message' => 'تم إلغاء التبرع الشهري بنجاح'], 200);
    }

    public function volunteerInProject($id)
    {
        $user = Auth::User();
        $project = Project::findOrFail($id);
        if ($project->duration_type != 'تطوعي') {
            return response()->json(['message' => 'إن هذا المشروع ليس مشروعاً تطوعياً'], 401);
        }
        if ($user->volunteer_status === 'معلق') {
            return response()->json(['message' => 'لا يزال طلب التطوع خاصتك قيد الدراسة، يمكنك البدء بالتطوع عندما يتم قبول طلبك'], 401);
        }
        if ($user->volunteer_status === 'مرفوض') {
            return response()->json(['message' => 'تم رفض طلب تطوعك في الجمعية لأسباب متعلقة بسياسة الجمعية، لمتابعة التفاصيل أو الاعتراض، يُرجى التواصل مع إدارة التطبيق على صفحة الفيسبوك الخاصة بالجمعية'], 401);
        }
        if ($user->role != 'متطوع') {
            return response()->json(['message' => 'لا يمكنك التطوع في هذا المشروع، للمساهمة في نشر الخير يمكنك التسجيل كمتطوع في جمعيتنا عن طريق تعبئة استبيان التطوع الخاص بنا'], 401);
        }
        if ($user->ban) {
            return response()->json(['message' => 'تم إيقاف تطوعك في الجمعية بسبب مخالفات في تنفيذ المهام التطوعية، لمتابعة التفاصيل أو الاعتراض، يُرجى التواصل مع إدارة التطبيق على صفحة الفيسبوك الخاصة بالجمعية'], 401);
        }
        if ($user->is_working) {
            return response()->json(['message' => 'لا يمكنك التطوع في مشروعين بنفس الوقت'], 401);
        }
        if ($project->current_amount == $project->total_amount) {
            return response()->json(['message' => 'إن العدد مكتمل في هذا المشروع، يمكنك البحث عن فرصة تطوعية أخرى'], 401);
        }
        $project->current_amount++;
        $project->save();
        $user->is_working = true;
        $user->save();

        $volunteer = [
            'user_id' => $user->id,
            'project_id' => $project->id,
        ];
        Volunteer::create($volunteer);
        return response()->json(['message' => 'تمت العملية بنجاح، أنت الآن متطوع في هذا المشروع'], 200);
    }

    //ابرز المحسنين 
    public function getDonorsByPoints()
    {
        $users = User::whereIn('role', ['متبرع', 'متطوع'])
            ->orderByDesc('points')
            ->take(10)
            ->get(['full_name', 'points']);

        return response()->json([
            'top_donors' => $users
        ], 200);
    }
}
