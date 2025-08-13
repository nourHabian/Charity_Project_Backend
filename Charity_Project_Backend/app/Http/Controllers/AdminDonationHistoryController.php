<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AdminDonationHistory;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDonationHistoryController extends Controller
{
    public function getAdminDonations()
    {
        $donations = AdminDonationHistory::orderBy('created_at', 'desc')
            ->get();

        foreach ($donations as $donation) {
            $admin = Admin::where('id', $donation['admin_id'])->first();
            $project = Project::where('id', $donation['project_id'])->first();
            unset($donation->admin_id);
            unset($donation->project_id);
            $donation['admin'] = $admin;
            $donation['project'] = $project;
        }

        return response()->json($donations, 200);
    }
}
