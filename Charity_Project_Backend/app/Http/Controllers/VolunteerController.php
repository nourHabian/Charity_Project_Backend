<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddVolunteerRequest;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{

    //التسجيل على استبيان التطوع 
    
    public function addvolunteerrequest(AddVolunteerRequest $request)
{
    $validatedData = $request->validated();
    $volunteer = Volunteer::create($validatedData);

    $user = User::find($validatedData['user_id']);
    if ($user) {
        $user->role = 'متطوع';
        $user->save();
    }

    return response()->json($volunteer, 201);
}

//عرض كل استبيانات التطوع


public function getallvolunteerrequest(){
 
     $volunteer_request = Volunteer::all();
        return response()->json($volunteer_request , 200);

}



}
