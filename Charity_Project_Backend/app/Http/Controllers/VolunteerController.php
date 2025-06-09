<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddVolunteerRequest;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerController extends Controller
{

    //التسجيل على استبيان التطوع 

    public function addVolunteerRequest(AddVolunteerRequest $request)
    {

        $user_id = Auth::User()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
        $volunteer = Volunteer::create($validatedData);

        $user = User::find($validatedData['user_id']);
        if ($user) {
            $user->role = 'متطوع';
            $user->save();
        }

        return response()->json($volunteer, 201);
    }

    //عرض كل استبيانات التطوع


    public function getAllVolunteerRequests()
    {


        $volunteer_request = Volunteer::all();
        return response()->json($volunteer_request, 200);
    }
}
