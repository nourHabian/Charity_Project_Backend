<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VolunteerRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VolunteerRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requests = [
            [
                'user_id' => 6,
                'phone_number' => "0987654321",
                'age' => 21,
                'place_of_residence' => "دمشق",
                'gender' => "أنثى",
                'your_last_educational_qualification' => "طالب جامعي",
                'your_studying_domain' => "هندسة معلوماتية",
                'volunteering_hours' => 5,
                'purpose_of_volunteering' => "مساعدة المحتاجين عن طريق التبرع بوقتي لخدمتهم",
                'volunteer_status' => "مرفوض"
            ],
            [
                'user_id' => 6,
                'phone_number' => "0987654322",
                'age' => 21,
                'place_of_residence' => "دمشق",
                'gender' => "أنثى",
                'your_last_educational_qualification' => "طالب جامعي",
                'your_studying_domain' => "هندسة معلوماتية",
                'volunteering_hours' => 10,
                'purpose_of_volunteering' => "مساعدة المحتاجين عن طريق التبرع بوقتي لخدمتهم",
                'volunteer_status' => "مرفوض"
            ],
            [
                'user_id' => 6,
                'phone_number' => "0987654323",
                'age' => 21,
                'place_of_residence' => "دمشق",
                'gender' => "أنثى",
                'your_last_educational_qualification' => "ماجستير",
                'your_studying_domain' => "هندسة معلوماتية",
                'volunteering_hours' => 15,
                'purpose_of_volunteering' => "مساعدة المحتاجين عن طريق التبرع بوقتي لخدمتهم",
                'volunteer_status' => "معلق"
            ],

            [
                'user_id' => 7,
                'phone_number' => "0987654324",
                'age' => 21,
                'place_of_residence' => "دمشق",
                'gender' => "أنثى",
                'your_last_educational_qualification' => "طالب جامعي",
                'your_studying_domain' => "هندسة معلوماتية",
                'volunteering_hours' => 5,
                'purpose_of_volunteering' => "مساعدة المحتاجين عن طريق التبرع بوقتي لخدمتهم",
                'volunteer_status' => "مقبول"
            ],
            [
                'user_id' => 8,
                'phone_number' => "0987654325",
                'age' => 21,
                'place_of_residence' => "دمشق",
                'gender' => "أنثى",
                'your_last_educational_qualification' => "طالب جامعي",
                'your_studying_domain' => "هندسة معلوماتية",
                'volunteering_hours' => 5,
                'purpose_of_volunteering' => "مساعدة المحتاجين عن طريق التبرع بوقتي لخدمتهم",
                'volunteer_status' => "مرفوض"
            ],
            [
                'user_id' => 8,
                'phone_number' => "0987654326",
                'age' => 21,
                'place_of_residence' => "دمشق",
                'gender' => "أنثى",
                'your_last_educational_qualification' => "طالب جامعي",
                'your_studying_domain' => "هندسة معلوماتية",
                'volunteering_hours' => 5,
                'purpose_of_volunteering' => "مساعدة المحتاجين عن طريق التبرع بوقتي لخدمتهم",
                'volunteer_status' => "مقبول"
            ],
            [
                'user_id' => 9,
                'phone_number' => "0987654327",
                'age' => 21,
                'place_of_residence' => "دمشق",
                'gender' => "أنثى",
                'your_last_educational_qualification' => "طالب جامعي",
                'your_studying_domain' => "هندسة معلوماتية",
                'volunteering_hours' => 5,
                'purpose_of_volunteering' => "مساعدة المحتاجين عن طريق التبرع بوقتي لخدمتهم",
                'volunteer_status' => "معلق"
            ],
            [
                'user_id' => 9,
                'phone_number' => "0987654328",
                'age' => 21,
                'place_of_residence' => "دمشق",
                'gender' => "أنثى",
                'your_last_educational_qualification' => "طالب جامعي",
                'your_studying_domain' => "هندسة معلوماتية",
                'volunteering_hours' => 5,
                'purpose_of_volunteering' => "مساعدة المحتاجين عن طريق التبرع بوقتي لخدمتهم",
                'volunteer_status' => "مقبول"
            ],
            [
                'user_id' => 10,
                'phone_number' => "0987654329",
                'age' => 21,
                'place_of_residence' => "دمشق",
                'gender' => "أنثى",
                'your_last_educational_qualification' => "طالب جامعي",
                'your_studying_domain' => "هندسة معلوماتية",
                'volunteering_hours' => 5,
                'purpose_of_volunteering' => "مساعدة المحتاجين عن طريق التبرع بوقتي لخدمتهم",
                'volunteer_status' => "معلق"
            ],
            [
                'user_id' => 11,
                'phone_number' => "0987654320",
                'age' => 21,
                'place_of_residence' => "دمشق",
                'gender' => "أنثى",
                'your_last_educational_qualification' => "طالب جامعي",
                'your_studying_domain' => "هندسة معلوماتية",
                'volunteering_hours' => 5,
                'purpose_of_volunteering' => "مساعدة المحتاجين عن طريق التبرع بوقتي لخدمتهم",
                'volunteer_status' => "مرفوض"
            ],
        ];

        foreach ($requests as $request) {
            VolunteerRequest::create($request);
            $user = User::find($request['user_id']);

            if ($user) {
                $user->update([
                    'volunteer_status' => $request['volunteer_status'],
                ]);
                if ($request['volunteer_status'] === 'مقبول') {
                    $user->update([
                        'role' => 'متطوع',
                    ]);
                }
            }
        }
    }
}
