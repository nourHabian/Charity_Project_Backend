<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddVolunteerRequest;
use App\Models\Notification;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\VolunteerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerController extends Controller
{

    //التسجيل على استبيان التطوع
    public function addVolunteerRequest(AddVolunteerRequest $request)
    {
        $user = Auth::user();

        if ($user->volunteer_status === 'مقبول' || $user->volunteer_status === 'معلق' || $user->ban) {
            return response()->json([
                'message' => 'لقد قمت بالتسجيل على استبيان التطوع مسبقًا ولا يمكنك التسجيل مرة أخرى.'
            ], 409);
        }

        $validatedData = $request->validated();
        if (
            isset($validatedData['phone_number']) &&
            User::where('phone_number', $validatedData['phone_number'])
            ->where('id', '!=', $user->id)
            ->exists()
        ) {
            return response()->json([
                'message' => 'رقم الهاتف مستخدم بالفعل من قبل مستخدم آخر.'
            ], 422);
        }

        $user->volunteer_status = 'معلق';
        $user->save();
        $validatedData['volunteer_status'] = 'معلق';
        $validatedData['user_id'] = $user->id;
        VolunteerRequest::create($validatedData);


        $validatedData['full_name'] = $user->full_name;
        $notification = [
            'user_id' => $user->id,
            'title' => 'تم استلام طلب التطوع',
            'message' => 'تم استلام طلب تطوعك سيتم مراجعته و التواصل معك لاحقاً'
        ];
        Notification::create($notification);

        return response()->json(
            $validatedData,
            201
        );
    }





}