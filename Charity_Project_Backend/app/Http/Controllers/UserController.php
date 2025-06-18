<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Charity;
use App\Models\Donation;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register(Request $request)
    {
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
            'password' => Hash::make($request->password)
        ]);
        return response()->json(['message' => 'User Registered Successfully', 'user' => $user], 200);
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
        return response()->json($user, 200);
    }

    public function addToBalance(Request $request)
    {
        $validate = $request->validate([
            'card_number' => 'required|digits:16',
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
            'amount' => 'required|numeric|min:0.1'
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
            'amount' => 'required|numeric|min:1000'
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
            'message' => 'تم استلام زكاتك وسيتم إيصالها إلى مستحقيها في أقرب وقت ممكن، جزاك الله خيراً. '
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
        $user->points += $request->amount / 1000;
        $user->save();

        // add money to somewhere
        $charity = Charity::findOrFail(1);
        $charity->health_projects_balance += $request->amount;
        $charity->number_of_donations++;
        $charity->save();
        return response()->json(['message' => 'تم استلام الزكاة بنجاح'], 200);
    }
}
