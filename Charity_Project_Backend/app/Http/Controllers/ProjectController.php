<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBeneficiaryProjectRequest;
use App\Http\Requests\AddCharityProjectRequest;
use App\Http\Requests\AddProjectRequest;
use App\Http\Requests\AddVolunteerProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Charity;
use App\Models\Notification;
use App\Models\Project;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function home()
    {
        $projects = Project::where('duration_type', 'دائم')->get();
        foreach ($projects as $project) {
            $project['photo_url'] = asset(Storage::url($project['photo']));
            $project['type'] = Type::findOrFail($project->type_id)->name;
        }
        return response()->json($projects, 200);
    }

    public function healthProjects()
    {
        $projects = Project::where('type_id', 1)->where('duration_type', '!=', 'تطوعي')->where('duration_type', '!=', 'دائم') ->where('status', '!=', 'منتهي') ->get();
        foreach ($projects as $project) {
            $project['photo_url'] = asset(Storage::url($project['photo']));
            $percentage = ($project['current_amount'] / $project['total_amount']) * 100.0;
             if ($percentage >= 100 && $project->status !== 'منتهي') {
            $project->status = 'منتهي';
            $project->save();
            continue;
            }
            $project['percentage'] = $percentage;
            $project['type'] = Type::findOrFail($project->type_id)->name;
        }
        //  $projects = $projects->filter(function ($project) {
        //     return $project->status !== 'منتهي';
        //     })->values();

        return response()->json($projects, 200);
    }

    public function educationalProjects()
    {
        $projects = Project::where('type_id', 2)->where('duration_type', '!=', 'تطوعي')->where('duration_type', '!=', 'دائم')->where('status', '!=', 'منتهي')->get();
        foreach ($projects as $project) {
            $project['photo_url'] = asset(Storage::url($project['photo']));
            $percentage = ($project['current_amount'] / $project['total_amount']) * 100.0;
             if ($percentage >= 100 && $project->status !== 'منتهي') {
            $project->status = 'منتهي';
            $project->save();
            continue;
            }
            $project['percentage'] = $percentage;
            $project['type'] = Type::findOrFail($project->type_id)->name;
        }
        return response()->json($projects, 200);
    }

    public function residentialProjects()
    {
        $projects = Project::where('type_id', 3)->where('duration_type', '!=', 'تطوعي')->where('duration_type', '!=', 'دائم')->where('status', '!=', 'منتهي')->get();
        foreach ($projects as $project) {
            $project['photo_url'] = asset(Storage::url($project['photo']));
            $percentage = ($project['current_amount'] / $project['total_amount']) * 100.0;
             if ($percentage >= 100 && $project->status !== 'منتهي') {
            $project->status = 'منتهي';
            $project->save();
            continue; 
            }
            $project['percentage'] = $percentage;
            $project['type'] = Type::findOrFail($project->type_id)->name;
        }
        return response()->json($projects, 200);
    }

    public function nutritionalProjects()
    {
        $projects = Project::where('type_id', 4)->where('duration_type', '!=', 'تطوعي')->where('duration_type', '!=', 'دائم')->where('status', '!=', 'منتهي')->get();
        foreach ($projects as $project) {
            $project['photo_url'] = asset(Storage::url($project['photo']));
            $percentage = ($project['current_amount'] / $project['total_amount']) * 100.0;
             if ($percentage >= 100 && $project->status !== 'منتهي') {
            $project->status = 'منتهي';
            $project->save();
            continue; 
            }
            $project['percentage'] = $percentage;
            $project['type'] = Type::findOrFail($project->type_id)->name;
        }
        return response()->json($projects, 200);
    }

    public function religionProjects()
    {
        $projects = Project::where('type_id', 7)->where('duration_type', '!=', 'تطوعي')->where('duration_type', '!=', 'دائم')->where('status', '!=', 'منتهي')->get();
        foreach ($projects as $project) {
            $project['photo_url'] = asset(Storage::url($project['photo']));
            $percentage = ($project['current_amount'] / $project['total_amount']) * 100.0;
            if ($percentage >= 100 && $project->status !== 'منتهي') {
            $project->status = 'منتهي';
            $project->save();
            continue; 
            }
            $project['percentage'] = $percentage;
            $project['type'] = Type::findOrFail($project->type_id)->name;
        }
        return response()->json($projects, 200);
    }

    public function emergencyProjects()
    {
        $projects = Project::where('priority', 'حرج')->where('duration_type', '!=', 'تطوعي')->where('duration_type', '!=', 'دائم')->where('status', '!=', 'منتهي')->get();
        foreach ($projects as $project) {
            $project['photo_url'] = asset(Storage::url($project['photo']));
            $percentage = ($project['current_amount'] / $project['total_amount']) * 100.0;
             if ($percentage >= 100 && $project->status !== 'منتهي') {
            $project->status = 'منتهي';
            $project->save();
            continue; 
            }
            $project['percentage'] = $percentage;
            $project['type'] = Type::findOrFail($project->type_id)->name;
        }
        return response()->json($projects, 200);
    }


    // لازم يتعدل عليه انو احتمال ينسحب من رصيد الجمعية قيمة وقت يضيف مشروع
    public function addCharityProject(AddCharityProjectRequest $request)
    {
        $validatedData = $request->validated();

        // get the type id
        $type = Type::where('name', $validatedData['type_id'])->first();
        $validatedData['type_id'] = $type->id;

        // update charity balance
        $charity = Charity::findOrFail(1);
        $is_enough = true;
        if ($type->name === 'صحي') {
            $charity->health_projects_balance -= $validatedData['current_amount'];
            if ($charity->health_projects_balance < 0) $is_enough = false;
        } else if ($type->name === 'تعليمي') {
            $charity->educational_projects_balance -= $validatedData['current_amount'];
            if ($charity->educational_projects_balance < 0) $is_enough = false;
        } else if ($type->name === 'سكني') {
            $charity->housing_projects_balance -= $validatedData['current_amount'];
            if ($charity->housing_projects_balance < 0) $is_enough = false;
        } else if ($type->name === 'غذائي') {
            $charity->nutritional_projects_balance -= $validatedData['current_amount'];
            if ($charity->nutritional_projects_balance < 0) $is_enough = false;
        } else {
            return response()->json(['message' => 'error has occurred'], 401);
        }
        if (!$is_enough) {
            return response()->json(['message' => 'لا يوجد رصيد كافي في رصيد الجمعية للمساهمة في هذا المشروع'], 401);
        }
        $charity->save();

        // save the photo
        $file = $validatedData['photo'];
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('temporary_projects_images', $fileName, 'public'); // Saves in storage/app/public/temporary_projects_images
        $validatedData['photo'] = $filePath;

        // create the project
        $project = Project::create($validatedData);

        // send notifications to donors if needed
        $users = User::all();
        if ($project->priority === 'حرج') {
            foreach ($users as $user) {
                if ($user->role === 'مستفيد') continue;
                $notification = [
                    'user_id' => $user->id,
                    'project_id' => $project->id,
                    'title' => 'نداء عاجل، هناك مشروع بحاجة لدعمك',
                    'message' => 'حالة عاجلة جديدة بحاجة إلى التدخل الفوري ' . $project->name . ' نأمل أن تكون من المبادرين لدعمها'
                ];
                Notification::create($notification);
            }
        }
        return response()->json($project, 201);
    }

    public function addBeneficiaryProject(AddBeneficiaryProjectRequest $request)
    {
        $validatedData = $request->validated();

        // get the type id
        $type = Type::where('name', $validatedData['type_id'])->first();
        $validatedData['type_id'] = $type->id;

        $beneficiary = User::where('phone_number', $validatedData['phone_number'])->first();
        if ($beneficiary->role !== 'مستفيد') {
            return response()->json(['message' => 'لا يوجد مستفيد مسجل في الجمعية بهذا الرقم'], 401);
        }

        // update charity balance
        $charity = Charity::findOrFail(1);
        $is_enough = true;
        if ($type->name === 'صحي') {
            $charity->health_projects_balance -= $validatedData['current_amount'];
            if ($charity->health_projects_balance < 0) $is_enough = false;
        } else if ($type->name === 'تعليمي') {
            $charity->educational_projects_balance -= $validatedData['current_amount'];
            if ($charity->educational_projects_balance < 0) $is_enough = false;
        } else if ($type->name === 'سكني') {
            $charity->housing_projects_balance -= $validatedData['current_amount'];
            if ($charity->housing_projects_balance < 0) $is_enough = false;
        } else if ($type->name === 'غذائي') {
            $charity->nutritional_projects_balance -= $validatedData['current_amount'];
            if ($charity->nutritional_projects_balance < 0) $is_enough = false;
        } else {
            return response()->json(['message' => 'error has occurred'], 401);
        }
        if (!$is_enough) {
            return response()->json(['message' => 'لا يوجد رصيد كافي في رصيد الجمعية للمساهمة في هذا المشروع'], 401);
        }
        $charity->save();

        // save the photo
        $file = $validatedData['photo'];
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('temporary_projects_images', $fileName, 'public'); // Saves in storage/app/public/temporary_projects_images
        $validatedData['photo'] = $filePath;

        $validatedData['duration_type'] = 'فردي';
        $validatedData['user_id'] = $beneficiary->id;
        unset($validatedData['phone_number']);

        // create the project
        $project = Project::create($validatedData);

        // send notifications to the beneficiary
        $notification = [
            'user_id' => $beneficiary->id,
            'project_id' => $project->id,
            'title' => 'تم نشر حالتك',
            'message' => 'تم نشر حالتك في التطبيق، نأمل أن تصل المساعدة إليك قريباً بإذن الله'
        ];
        Notification::create($notification);

        // send notifications to donors if needed
        $users = User::all();
        if ($project->priority === 'حرج') {
            foreach ($users as $user) {
                if ($user->role === 'مستفيد') continue;
                $notification = [
                    'user_id' => $user->id,
                    'project_id' => $project->id,
                    'title' => 'نداء عاجل، هناك مشروع بحاجة لدعمك',
                    'message' => 'حالة عاجلة جديدة بحاجة إلى التدخل الفوري ' . $project->name . ' نأمل أن تكون من المبادرين لدعمها'
                ];
                Notification::create($notification);
            }
        }
        return response()->json($project, 201);
    }

    public function addVolunteerProject(AddVolunteerProjectRequest $request) {
        $validatedData = $request->validated();
        $validatedData['photo'] = 'charity_logo/logo.png';

        // get the type id
        $type = Type::where('name', $validatedData['type_id'])->first();
        $validatedData['type_id'] = $type->id;

        $validatedData['duration_type'] = 'تطوعي';
        if ($type->name === 'عن بعد')
            $validatedData['location'] = 'عن بعد';

        // create project
        $project = Project::create($validatedData);
        
        // send notification to volunteers
        $users = User::all();
        foreach ($users as $user) {
            if ($user->role === 'متطوع') {
                $notification = [
                    'user_id' => $user->id,
                    'project_id' => $project->id,
                    'title' => 'فرصة تطوع جديدة بانتظارك',
                    'message' => 'مشروع تطوعي جديد متاح الآن ' . $project->name . ' يمكنك التقديم والمساهمة في خدمة المجتمع، انضم واصنع فرقاً'
                ];
                Notification::create($notification);
            }
        }
        return response()->json($project, 201);
    }


    public function deleteProject($id)
    {
        $project = Project::findOrFail($id);
        if ($project->current_amount != 0) {
            return response()->json(['message' => 'لا يمكن حذف هذا المشروع بسبب وجود تبرعات سابقة فيه.'], 401);
        }
        $project->delete();
        return response()->json(null, 204);
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


    /* public function editProject(UpdateProjectRequest $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->validated());
        return response()->json($project, 200);
    } */
}
