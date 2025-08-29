<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AdminDonationHistory;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminDonationHistoryController extends Controller
{
    public function getAdminDonations()
    {
        $admins = Admin::with(['donatedProjects'])->get();

        $result = $admins->map(function ($admin) {
            return [
                'admin_id' => $admin->id,
                'admin_name' => $admin->full_name,
                'admin_email' => $admin->email,
                'total_projects' => $admin->donatedProjects->count(),
                'donations' => $admin->donatedProjects->map(function ($project) {
                    return [
                        'project_id' => $project->id,
                        'project_name' => $project->name,
                        'project_description' => $project->description,
                        'project_photo' => asset(Storage::url($project->photo)),
                        'project_type' => $project->type->name,
                        'project_current_amount' => $project->current_amount,
                        'project_total_amount' => $project->total_amount,
                        'project_status' => $project->status,
                        'project_priority' => $project->priority,
                        'project_duration_type' => $project->duration_type,
                        'donation_amount' => $project->pivot->amount,
                        'donated_at' => $project->pivot->created_at,
                    ];
                }),
            ];
        });

        return response()->json($result, 200);
    }
}
