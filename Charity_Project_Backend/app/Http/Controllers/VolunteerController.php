<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddVolunteerRequest;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerController extends Controller
{
    // التسجيل على استبيان التطوع
    public function addVolunteerRequest(AddVolunteerRequest $request)
    {
        $user = Auth::user();

        if ($user->volunteer_status !== null) {
            return response()->json([
                'message' => 'لقد قمت بالتسجيل على استبيان التطوع مسبقًا ولا يمكنك التسجيل مرة أخرى.'
            ], 409);
        }

        $validatedData = $request->validated();
        $validatedData['volunteer_status'] = 'معلق';

        $user->update($validatedData);

        $volunteerInfo = $user->only([
            'full_name',
            'phone_number',
            'age',
            'volunteer_status',
            'place_of_residence',
            'gender',
            'your_last_educational_qualification',
            'your_studying_domain',
            'volunteering_hours',
            'purpose_of_volunteering',
        ]);

        return response()->json($volunteerInfo, 201);
    }

    public function getAllVolunteerRequests()
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return response()->json(['message' => 'غير مصرح لك بالوصول إلى هذه البيانات.'], 403);
        }

        // جلب المستخدمين الذين لديهم استبيانات تطوع
        $volunteerRequests = User::whereNotNull('volunteer_status')->get([
            'id',
            'full_name',
            'phone_number',
            'volunteer_status',
            'volunteering_domain',
            'purpose_of_volunteering',
            'place_of_residence',
            'gender',
            'age',
            'volunteering_hours',
            'your_last_educational_qualification'
        ]);

        return response()->json($volunteerRequests, 200);
    }
}
