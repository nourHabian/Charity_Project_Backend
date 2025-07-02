<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FavouriteController extends Controller
{
    public function addToFavourite(Request $request)
    {
        $projectId = $request->query('project_id');
        Project::findOrFail($projectId);
        Auth::user()->favouriteProjects()->syncWithoutDetaching($projectId);
        return response()->json(['message' => 'تمت إضافة المشروع إلى قائمة التبرع لاحقاً'], 200);
    }

    public function removeFromFavourite(Request $request)
    {
        $projectId = $request->query('project_id');

        Project::findOrFail($projectId);
        Auth::user()->favouriteProjects()->detach($projectId);

        return response()->json(['message' => 'تمت إزالة المشروع من قائمة التبرع لاحقاً'], 200);
    }

    public function getFavouriteProjects() 
{
    $projects = Auth::user()->favouriteProjects()->get()->map(function ($project) {
    return [
        'id' => $project->id,
        'name' => $project->name,
        'description' => $project->description,
        'photo_url' => $project->photo ? asset(Storage::url($project->photo)) : null,
        'total_amount' => $project->total_amount,
        'current_amount' => $project->current_amount,
        'status' => $project->status,
        'priority' => $project->priority,
        'duration_type' => $project->duration_type,
        'location' => $project->location,
    ];
});
return response()->json($projects, 200);
}


    public function searchFavourite(Request $request)
    {
        $query = $request->input('query');

        $results = Auth::user()->favouriteProjects()
            ->where('name', 'LIKE', '%' . $query . '%')
            ->get();

        return response()->json($results, 200);
    }
}