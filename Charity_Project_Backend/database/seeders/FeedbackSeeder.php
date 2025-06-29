<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $feedbacks = [
            ['user_id' => 2,
                'message' => 'شكر كبير لهذه الجمعية على صدقهم في تقديم الدعم و المساعدة ',
                'status' => 'مقبول',
            ],
            ['user_id' => 3,
                'message' => 'أتقدم بجزيل الشكر والامتنان لجمعيتكم الكريمة على الدعم والمساعدة التي قدمتموها لي. لقد كانت عونًا كبيرًا لي ولعائلتي في وقت الحاجة، وأسأل الله أن يجزيكم خير الجزاء ويبارك في جهودكم',
                'status' => 'مقبول',],
            
          
        ];

        foreach($feedbacks as $feedback) {
            Feedback::create(['user_id' => $feedback['user_id'],
                               'message'=>$feedback['message'],
                                 'status'=>$feedback['status']
        
        
        ]);
        }
    }
    }

