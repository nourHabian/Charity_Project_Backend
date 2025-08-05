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
            [
                'user_id' => 2,
                'user_name' => 'hala',
                'message' => 'شكر كبير لهذه الجمعية على صدقهم في تقديم الدعم و المساعدة ',
                'status' => 'مقبول',
            ],

            [
                'user_id' => 2,
                'user_name' => 'hala',
                'message' => 'بارك الله بجهودكم',
                'status' => 'معلق',
            ],
            [
                'user_id' => 2,
                'user_name' => 'hala',
                'message' => ' تأخرت المساعدة كتير، وكنت محتاجها قبل بوقت',
                'status' => 'مرفوض',
            ],
            [
                'user_id' => 2,
                'user_name' => 'hala',
                'message' => ' كل الامتنان والدعاء لكل من ساهم في إيصال هذه المساعدة',
                'status' => 'معلق',
            ],

            [
                'user_id' => 3,
                'user_name' => 'heba',
                'message' => 'أتقدم بجزيل الشكر والامتنان لجمعيتكم الكريمة على الدعم والمساعدة التي قدمتموها لي. لقد كانت عونًا كبيرًا لي ولعائلتي في وقت الحاجة، وأسأل الله أن يجزيكم خير الجزاء ويبارك في جهودكم',
                'status' => 'مقبول',
            ],

            [
                'user_id' => 3,
                'user_name' => 'heba',
                'message' => 'اشكركم لقد كنتم سبب في رسم الابتسامة على وجهي ووجوه أولادي  ',
                'status' => 'معلق',
            ],

            [
                'user_id' => 3,
                'user_name' => 'heba',
                'message' => ' الاستجابة بطيئة جدا  مقارنة بحاجتنا الملحّة',
                'status' => 'مرفوض',
            ],



        ];

        foreach ($feedbacks as $feedback) {
            Feedback::create([
                'user_id' => $feedback['user_id'],
                'user_name' => $feedback['user_name'],
                'message' => $feedback['message'],
                'status' => $feedback['status']


            ]);
        }
    }
}
