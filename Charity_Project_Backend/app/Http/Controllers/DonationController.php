<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class DonationController extends Controller
{
 public function getUserDonations()
{
    $user = Auth::user();

    $donations = Donation::with(['project:id,name,type'])
                         ->where('user_id', $user->id)
                         ->orderBy('created_at', 'desc')
                         ->get();

    $formattedDonations = $donations->map(function ($donation) {
        // البحث عن المستفيد حسب الرقم إذا كان نوع التبرع gift
        $recipient = null;
        if ($donation->type === 'gift' && $donation->recipient_number) {
            $recipient = \App\Models\User::where('phone_number', $donation->recipient_number)->first();
        }

        return [
            'id' => $donation->id,
            'amount' => $donation->amount,
            'type' => $donation->type,
            'recipient_number' => $donation->recipient_number,
            'recipient_name' => $recipient?->full_name,  // اسم المستفيد
            'created_at' => $donation->created_at,
            'project_name' => optional($donation->project)->name,
            'project_type' => optional($donation->project)->type,
        ];
    });

    return response()->json($formattedDonations, 200);
}}