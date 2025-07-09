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
            'user_name' => 'ha',
                'message' => 'شكر كبير لهذه الجمعية على صدقهم في تقديم الدعم و المساعدة ',
                'status' => 'مقبول',
            ],
            ['user_id' => 3,
             'user_name' => 'he',
                'message' => 'أتقدم بجزيل الشكر والامتنان لجمعيتكم الكريمة على الدعم والمساعدة التي قدمتموها لي. لقد كانت عونًا كبيرًا لي ولعائلتي في وقت الحاجة، وأسأل الله أن يجزيكم خير الجزاء ويبارك في جهودكم',
                'status' => 'مقبول',],
            
          
        ];

        foreach($feedbacks as $feedback) {
            Feedback::create(['user_id' => $feedback['user_id'],
                               'user_name'=> $feedback['user_name'],
                               'message'=>$feedback['message'],
                                 'status'=>$feedback['status']
        
        
        ]);
        }
    }
    }

