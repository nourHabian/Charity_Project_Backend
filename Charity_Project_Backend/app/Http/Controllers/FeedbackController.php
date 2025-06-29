<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{


    public function getAcceptedFeedbacks()
    {

        $feedbacks = Feedback::where('status', 'مقبول')->get();
        return response()->json([
            'Feedbacks' => FeedbackResource::collection($feedbacks)
        ], 200);
    }
}
