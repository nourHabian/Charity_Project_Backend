<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function addProject(AddProjectRequest  $request)
    {

        $validatedData = $request->validated();

        $project = Project::create($validatedData);
        return response()->json($project, 201);
    }


    public function editProject(UpdateProjectRequest $request, $id)
    {

        $project = Project::findOrFail($id);

        $project->update($request->validated());
        return response()->json($project, 200);
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
}
