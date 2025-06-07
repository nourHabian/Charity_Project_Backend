<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
     /**
      * Run the database seeds.
      */
     public function run(): void
     {
          $projects = [
               [
                    'project_type' => 'تعليمي',
                    'name' => 'دعم تعليم الأطفال في المناطق الفقيرة',
                    'description' => 'تعليم مهارات القراءة والكتابة للأطفال الذي ليس لهم فرص تعليم كافية',
                    'required_tasks' => 'شرح المفاهيم الصعبة، تحضير ملخصات، تقديم اختبارات تجريبية ',
                    'location' => 'عين ترما',
                    'volunteer_hours' => ' 3 ساعات أسبوعياً ',
                    'total_amount' => '10',
                    'current_amount' => '0',
                    'status' => 'in_progress',
                    'duration_type' => 'volunteer'

               ],

               [

                    'project_type' => 'تعليمي',
                    'name' => 'دعم الأطفال ذوي الاحتياجات الخاصة في التعليم. ',
                    'description' => 'مساعدة الأطفال ذوي الاحتياجات الخاصة في التعلم والتواصل',
                    'required_tasks' => 'تقديم الدعم الفردي، استخدام أساليب تعليمية متخصصة لتحفيز الأطفال على التعلم',
                    'location' => 'مركز الرعاية في باب مصلى',
                    'volunteer_hours' => '3 ساعات أسبوعياً ',
                    'total_amount' => '10',
                    'current_amount' => '0',
                    'status' => 'in_progress',
                    'duration_type' => 'volunteer'

               ],
               [

                    'project_type' => 'تعليمي',
                    'name' => 'دعم المتابعة الأكاديمية للأطفال اليتامى ',
                    'description' => 'تقديم دعم دراسي فردي لأبناء الجمعية دراسياً.',
                    'required_tasks' => 'متابعة علامات الطلاب، كتابة تقارير دورية، لقاء أولياء الأمور .',
                    'location' => 'مقر الجمعية في المهاجربن',
                    'volunteer_hours' => '6 ساعات أسبوعياً',
                    'total_amount' => '10',
                    'current_amount' => '0',
                    'status' => 'in_progress',
                    'duration_type' => 'volunteer'

               ],
               [

                    'project_type' => 'تعليمي',
                    'name' => 'تحضير محتوى تعليمي مطبوع ',
                    'description' => 'تصميم وإنشاء ملخصات أو أوراق تعليمية للأطفال حسب الصفوف',
                    'required_tasks' => 'تنسيق ملفات PDF ، جمع معلومات دراسية، طباعة وتجهيز النسخ',
                    'location' => 'مقر الجمعية في باب مصلى',
                    'volunteer_hours' => '4 ساعات',
                    'total_amount' => '10',
                    'current_amount' => '0',
                    'status' => 'in_progress',
                    'duration_type' => 'volunteer'

               ],
               [

                    'project_type' => 'ميداني',
                    'name' => 'توزيع طرود غذائية للعائلات المحتاجة ',
                    'description' => 'تجهيز وتوزيع سلال غذائية ضمن حملات الجمعية',
                    'required_tasks' => 'تعبئة الطرود، تحميلها، توزيعها على المستفيدين',
                    'location' => 'مستودع الجمعية في حي باب مصلى',
                    'volunteer_hours' => '4 ساعات يومياً',
                    'total_amount' => '8',
                    'current_amount' => '0',
                    'status' => 'in_progress',
                    'duration_type' => 'volunteer'

               ],
               [

                    'project_type' => 'ميداني',
                    'name' => 'تنظيم حملات نظافة في الأحياء الفقيرة ',
                    'description' => 'تنظيف الشوارع والأماكن العامة بالتعاون مع سكان الحي',
                    'required_tasks' => 'جمع النفايات، توزيع أدوات النظافة، توعية السكان',
                    'location' => 'احياء ريف دمشق.',
                    'volunteer_hours' => '3 ساعات أسبوعياً',
                    'total_amount' => '20',
                    'current_amount' => '0',
                    'status' => 'in_progress',
                    'duration_type' => 'volunteer'

               ],
               [

                    'project_type' => 'ميداني',
                    'name' => ' توصيل المساعدات للمسنين وذوي الاحتياجات الخاصة',
                    'description' => 'توصيل الأدوية والمساعدات الغذائية للمستفيدين غير القادرين على الحضور',
                    'required_tasks' => 'استلام المواد من الجمعية وتوصيلها للمنازل',
                    'location' => 'مختلف أحياء المدينة',
                    'volunteer_hours' => '2 ساعات يومياً.',
                    'total_amount' => '5',
                    'current_amount' => '0',
                    'status' => 'in_progress',
                    'duration_type' => 'volunteer'

               ],
               [

                    'project_type' => 'عن بعد',
                    'name' => ' دعم حملة التبرعات الإلكترونية',
                    'description' => 'الترويج لحملات التبرع عبر الإنترنت ومتابعة التبرعات.',
                    'required_tasks' => 'إنشاء محتوى ترويجي، التواصل مع المتبرعين، تحديث قاعدة البيانات',
                    'location' => 'عن بُعد',
                    'volunteer_hours' => '5 ساعات أسبوعياً.',
                    'total_amount' => '2',
                    'current_amount' => '0',
                    'status' => 'in_progress',
                    'duration_type' => 'volunteer'

               ],
               [

                    'project_type' => 'عن بعد',
                    'name' => 'تقديم دروس تعليمية عبر الإنترنت ',
                    'description' => 'تقديم دروس تقوية في مواد مختلفة للطلاب عبر الإنترنت',
                    'required_tasks' => 'تحضير الدروس، تقديمها عبر منصات التعليم عن بُعد، متابعة تقدم الطلاب',
                    'location' => 'عن بُعد',
                    'volunteer_hours' => '3 ساعات أسبوعياً',
                    'total_amount' => '4',
                    'current_amount' => '0',
                    'status' => 'in_progress',
                    'duration_type' => 'volunteer'

               ],
               [

                    'project_type' => 'صحي',
                    'name' => 'متابعة صحية للمسنين ',
                    'description' => 'زيارة دور المسنين لمتابعة حالتهم الصحية الأساسية.',
                    'required_tasks' => 'قياس الضغط، التأكد من أخذ الأدوية، تسجيل الملاحظات للطاقم الطبي.',
                    'location' => 'دار رعاية المسنين  حي المجتهد',
                    'volunteer_hours' => 'ساعتين.',
                    'total_amount' => '4 ',
                    'current_amount' => '0',
                    'status' => 'in_progress',
                    'duration_type' => 'volunteer'

               ],
               [

                    'project_type' => 'صحي',
                    'name' => 'دعم نفسي للأطفال المصابين بأمراض مزمنة ',
                    'description' => 'تنظيم أنشطة ترفيهية وداعمة نفسياً للأطفال مرضى السكري أو السرطان.',
                    'required_tasks' => 'جلسات رسم، ألعاب جماعية، محادثات تحفيزية',
                    'location' => 'ريف دمشق ',
                    'volunteer_hours' => 'ساعات أسبوعياً.',
                    'total_amount' => '3',
                    'current_amount' => '0',
                    'status' => 'in_progress',
                    'duration_type' => 'volunteer'

               ]



          ];
          foreach ($projects as $projectData) {
               $project = Project::create([
                    'project_type' => $projectData['project_type'],
                    'name' => $projectData['name'],
                    'description' => $projectData['description'],
                    'required_tasks' => $projectData['required_tasks'],
                    'location' => $projectData['location'],
                    'volunteer_hours' => $projectData['volunteer_hours'],
                    'total_amount' => $projectData['total_amount'],
                    'current_amount' => $projectData['current_amount'],
                    'status' => $projectData['status'],
                    'duration_type' => $projectData['duration_type'],
               ]);
          }
     }
}
