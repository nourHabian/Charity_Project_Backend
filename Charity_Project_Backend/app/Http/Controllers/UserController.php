<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
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

        return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $token], 200);
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
        $user_id = Auth::user()->id;
        $userData = User::findOrFail($user_id);
        return new UserResource($userData);
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

    public function giveGift(Request $request) {
        // بدي خزن هاد الشي بسجل التبرعات تبعي
        // بدي ابعت للمحتاج اشعار انو وصلو هدية
        // ضيف واحد على عدد المتبرعين الكلي وعدد المستفيدين الكلي

        $validate = $request->validate([
            'phone_number' => 'required|string|min:6|max:10|unique:users,phone_number',
            'beneficiary_name' => 'required|string|max:40',
            'amount' => 'required|numeric|min:0.1'
        ]);
        $user = Auth::user();
        $beneficiary = User::where('phone_number', $request->phone_number)->first();
        if ($beneficiary || $beneficiary->role == 'محتاج') {
            if ($request->amount > $user->balance) {
                return response()->json(['message' => 'لا يوجد لديك رصيد كافي للقيام بهذه العملية، الرجاء شحن المحفظة والمحاولة مرة أخرى'], 422);
            }
            $user->balance -= $request->amount;
            $user->save();
            // $notification = [
            //     'user_id' => $beneficiary->id,
            //     'title' => 'تم توصيل هدية إليك',
            //     'message' => 'تم توصيل هدية إليك من أحد المتبرعين بمبلغ ' . $request->amount . ' نأمل أن تكون سبباً في رسم البسمة على وجهك.'
            // ];
            // Notification::create($notification);
        } else {
            return response()->json(['message' => 'لقد حدث خطأ! يبدو أن هذا المحتاج غير مسجل لدينا في التطبيق، يمكنك دعوته للتسجيل على صفحة الويب الخاصة بنا'], 404);
        }
    }

}
