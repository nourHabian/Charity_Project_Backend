<?php

namespace App\Http\Controllers;

use App\Models\Charity;
use App\Models\Donation;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function monthlyDonations()
    {
        // اذا اليوم اول الشهر بس كمان لازم شيك انو اخر مرة سحبت من العالم كان الشهر الماضي
        if (Carbon::now()->day === 23) { 
            $users = User::where('monthly_donation', '!=', 0)->get();
            foreach ($users as $user) {
                if ($user->last_monthly_donation != null && Carbon::today()->isSameDay($user->last_monthly_donation)) {
                    return response()->json(['message' => 'you did monthly donation this month'], 200);
                }
                if ($user->monthly_donation <= $user->balance) {
                    // edit balance and get points
                    $user->balance -= $user->monthly_donation;
                    $user->points += floor(5 * log(1 + $user->monthly_donation));
                    $user->last_monthly_donation = Carbon::today();
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

                    // add money somewhere
                    $charity = Charity::findOrFail(1);
                    $charity->health_projects_balance += $user->monthly_donation;
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
        return response()->json(['message' => 'today is not the first of the month'], 401);
    }
}
