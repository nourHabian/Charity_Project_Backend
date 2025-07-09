<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{


    public function getAcceptedFeedbacks()
    {

        $feedbacks = Feedback::where('status', 'مقبول')->get();
        return response()->json([
            'Feedbacks' => FeedbackResource::collection($feedbacks)
        ], 200);
    }

    public function submitFeedback(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'مستفيد') {
            return response()->json([
                'message' => 'فقط المستفيدين يمكنهم إرسال الفيدباك.'
            ], 403);
        }

        if (!$user->beneficiaryRequests()->exists()) {
            return response()->json([
                'message' => 'يجب أن تقوم بتقديم طلب مساعدة واحد على الأقل قبل إرسال الفيدباك.'
            ], 403);
        }

        $validated = $request->validate([
            'user_name' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:1000',
        ]);

        $feedback = Feedback::create([
            'user_id' => $user->id,
            'user_name' => $validated['user_name'],
            'message' => $validated['message'],
            'status' => 'معلق',
        ]);

        return response()->json([
            'user_name' => $validated['user_name'],
            'message' => 'تم إرسال الفيدباك بنجاح، وسيتم مراجعته من قبل الإدارة.',
            'feedback_id' => $feedback->id
        ], 201);
    }
}
