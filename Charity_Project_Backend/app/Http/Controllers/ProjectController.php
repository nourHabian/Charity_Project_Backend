<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Notification;
use App\Models\Project;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function addProject(AddProjectRequest $request)
    {
        $validatedData = $request->validated();
        // تزبيط تخزين الصورة بحال ما كان مشروع تطوعي
        $project = Project::create($validatedData);
        $users = User::all();
        if ($project->duration_type == 'تطوعي') {
            foreach ($users as $user) {
                if ($user->role == 'متطوع') {
                    $notification = [
                        'user_id' => $user->id,
                        'title' => 'فرصة تطوع جديدة بانتظارك',
                        'message' => 'مشروع تطوعي جديد متاح الآن ' . $project->name . ' يمكنك التقديم والمساهمة في خدمة المجتمع، انضم واصنع فرقاً'
                    ];
                    Notification::create($notification);
                }
            }
        } else if ($project->priority == 'حرج') {
            foreach ($users as $user) {
                if ($user->role == 'محتاج') continue;
                $notification = [
                    'user_id' => $user->id,
                    'title' => 'نداء عاجل ، هناك مشروع بحاجة لدعمك',
                    'message' => 'حالة عاجلة جديدة بحاجة إلى التدخل الفوري '. $project->name .' نأمل أن تكون من المبادرين لدعمها'
                ];
                Notification::create($notification);
            }
        }
        if ($project->duration_type == 'فردي') {
            $notification = [
                'user_id' => $project->user_id,
                'title' => 'تم نشر حالتك',
                'message' => 'تم نشر حالتك في التطبيق، نأمل أن تصل المساعدة إليك قريباً بإذن الله'
            ];
            Notification::create($notification);
        }
        return response()->json($project, 201);
    }

    //عرض كل المشاريع 

    public function getAllProjects()
    {

        $project = Project::all();
        return response()->json($project, 200);
    }

    //ارجاع المشاريع التطوع حسب التايب
    public function getVolunteerProjectsByType($volunteeringDomain)
    {
        $type = Type::where('name', $volunteeringDomain)->first();

        if ($type) {
            $projects = Project::where('type_id', $type->id)
                ->where('duration_type', 'تطوعي')
                ->get();

            return response()->json($projects, 200);
        } else {
            return response()->json(['message' => 'لا يوجد نوع بهذا الاسم'], 404);
        }
    }



    public function deleteProject($id)
    {
        // تزبيط انو الحذف بصير بس بحال الcurrent amount كانت تساوي الصفر
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
