<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Notification;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function addProject(AddProjectRequest $request)
    {
        $validatedData = $request->validated();
        $project = Project::create($validatedData);
        $users = User::all();
        if ($project->duration_type == 'تطوعي') {
            foreach ($users as $user) {
                if ($user->role == 'متطوع') {
                    $notification = [
                        'user_id' => $user->id,
                        'message' => ['ساهم في التطوع لهذا المشروع']
                    ];
                    Notification::create($notification);
                }
                
            }
        }
        else if ($project->priority == 'حرج') {
            foreach ($users as $user) {
                if ($user->role == 'محتاج') continue;
                $notification = [
                    'user_id' => $user->id,
                    'message' => ['ساهم في التبرع لهذه الحالة الطارئة']
                ];
                Notification::create($notification);
            }
        }
        // اذا كان المشروع نوعو فردي لازم روح لعند المحتاج يلي طالب هاد التبرع وابعتلو نوتفيكيشن انو نزلت حالتك بالمشروع
        // لازم شيك انو الكلفة الابتدائية يلي دخلها اصغر من رصيد الجمعية لهاد النوع
        return response()->json($project, 201);
    }



    public function getallProject()
    {

        $project = Project::all();
        return response()->json($project, 200);
    }


    public function deleteProject($id)
    {

        $project = Project::findOrFail($id);

        $project->delete();
        return response()->json(null, 204);
    }


    /* public function editProject(UpdateProjectRequest $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->validated());
        return response()->json($project, 200);
    } */
}
