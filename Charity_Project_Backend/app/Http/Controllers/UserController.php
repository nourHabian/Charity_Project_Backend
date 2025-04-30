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
            'full_name' => 'required|string|max:250',
            'phone_number' => 'required|string|min:6|max:10|unique:users,phone_number',
            'email' => 'required|string|email|unique:users,email|max:250',
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
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6|max:10|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'the old password is incorrect'], 400);
        }

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
}
