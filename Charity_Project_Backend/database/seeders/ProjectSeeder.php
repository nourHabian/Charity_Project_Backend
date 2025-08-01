<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Container\Attributes\Storage as AttributesStorage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProjectSeeder extends Seeder
{
     /**
      * Run the database seeds.
      */
     public function run(): void
     {
          $volunteer_projects = [
               [
                    'type_id' => 2,
                    'name' => 'دعم تعليم الأطفال في المناطق الفقيرة',
                    'description' => 'تعليم الأطفال مهارات القراءة والكتابة ومساعدتهم على الفهم. يشمل ذلك تبسيط الدروس وتحفيزهم على التعلّم. يتم التركيز على الأطفال المحرومين من فرص تعليمية. الهدف هو تعزيز قدراتهم وتمكينهم دراسياً.',
                    'required_tasks' => 'شرح المفاهيم الصعبة، تحضير ملخصات، تقديم اختبارات تجريبية ',
                    'location' => 'عين ترما',
                    'volunteer_hours' => ' 3 ساعات أسبوعياً ',
                    'total_amount' => '10',
                    'current_amount' => '0',
                    'duration_type' => 'تطوعي',
                    'photo' => 'charity_logo/logo.png',

               ],

               [

                    'type_id' => 2,
                    'name' => 'دعم الأطفال ذوي الاحتياجات الخاصة في التعليم. ',
                    'description' => 'مساندة الأطفال ذوي الاحتياجات الخاصة لتحسين مهاراتهم التعليمية. استخدام وسائل خاصة لتسهيل التعلّم والتواصل. دعم فردي يعزز من ثقتهم بأنفسهم. بيئة تعليمية تراعي ظروفهم.',
                    'required_tasks' => 'تقديم الدعم الفردي، استخدام أساليب تعليمية متخصصة لتحفيز الأطفال على التعلم',
                    'location' => 'مركز الرعاية في باب مصلى',
                    'volunteer_hours' => '3 ساعات أسبوعياً ',
                    'total_amount' => '10',
                    'current_amount' => '0',
                    'duration_type' => 'تطوعي',
                    'photo' => 'charity_logo/logo.png',

               ],
               [

                    'type_id' => 2,
                    'name' => 'دعم المتابعة الأكاديمية للأطفال اليتامى ',
                    'description' => 'تقديم دعم دراسي للأطفال اليتامى المنتسبين للجمعية. تشمل المهمة شرح الدروس وتحفيز الطلاب على النجاح. تطوير مهاراتهم الدراسية والتنظيمية. بناء الثقة بالنفس والاستمرارية في التعلّم.',
                    'required_tasks' => 'متابعة علامات الطلاب، كتابة تقارير دورية، لقاء أولياء الأمور .',
                    'location' => 'مقر الجمعية في المهاجربن',
                    'volunteer_hours' => '6 ساعات أسبوعياً',
                    'total_amount' => '10',
                    'current_amount' => '0',
                    'duration_type' => 'تطوعي',
                    'photo' => 'charity_logo/logo.png',

               ],
               [

                    'type_id' => 2,
                    'name' => 'تحضير محتوى تعليمي مطبوع ',
                    'description' => 'إنشاء مواد تعليمية مطبوعة مناسبة لمستوى الطلاب. إعداد أوراق عمل وملخصات منظمة وجذابة. تنسيق ملفات PDF وتقديم محتوى يسهل الفهم. الهدف تحسين العملية التعليمية للأطفال.',
                    'required_tasks' => 'تنسيق ملفات PDF ، جمع معلومات دراسية، طباعة وتجهيز النسخ',
                    'location' => 'مقر الجمعية في باب مصلى',
                    'volunteer_hours' => '4 ساعات',
                    'total_amount' => '10',
                    'current_amount' => '0',
                    'duration_type' => 'تطوعي',
                    'photo' => 'charity_logo/logo.png',

               ],
               [

                    'type_id' => 5,
                    'name' => 'توزيع طرود غذائية للعائلات المحتاجة ',
                    'description' => 'المشاركة في تجهيز وتوزيع سلال غذائية موسمية. تخفيف الأعباء المعيشية للعائلات المحتاجة. العمل بروح الاحترام والتكافل المجتمعي. مساهمة فعالة في دعم الأمن الغذائي.',
                    'required_tasks' => 'تعبئة الطرود، تحميلها، توزيعها على المستفيدين',
                    'location' => 'مستودع الجمعية في حي باب مصلى',
                    'volunteer_hours' => '4 ساعات يومياً',
                    'total_amount' => '8',
                    'current_amount' => '0',
                    'duration_type' => 'تطوعي',
                    'photo' => 'charity_logo/logo.png',

               ],
               [

                    'type_id' => 5,
                    'name' => 'تنظيم حملات نظافة في الأحياء الفقيرة ',
                    'description' => 'تنظيف الشوارع والأماكن العامة في المناطق الفقيرة. تشجيع السكان على العناية بحارتهم. رفع الوعي المجتمعي بالنظافة والبيئة. خلق بيئة صحية وآمنة للأهالي.',
                    'required_tasks' => 'جمع النفايات، توزيع أدوات النظافة، توعية السكان',
                    'location' => 'احياء ريف دمشق.',
                    'volunteer_hours' => '3 ساعات أسبوعياً',
                    'total_amount' => '20',
                    'current_amount' => '0',
                    'duration_type' => 'تطوعي',
                    'photo' => 'charity_logo/logo.png',

               ],
               [

                    'type_id' => 5,
                    'name' => ' توصيل المساعدات للمسنين وذوي الاحتياجات الخاصة',
                    'description' => 'إيصال مساعدات غذائية ودوائية للمستفيدين في منازلهم. مراعاة الخصوصية وظروف كبار السن والمرضى. تقديم الدعم اللوجستي بروح إنسانية راقية. نشاط لمن يحبون العطاء الصامت.',
                    'required_tasks' => 'استلام المواد من الجمعية وتوصيلها للمنازل',
                    'location' => 'مختلف أحياء المدينة',
                    'volunteer_hours' => '2 ساعات يومياً.',
                    'total_amount' => '5',
                    'current_amount' => '0',
                    'duration_type' => 'تطوعي',
                    'photo' => 'charity_logo/logo.png',

               ],
               [

                    'type_id' => 6,
                    'name' => ' دعم حملة التبرعات الإلكترونية',
                    'description' => 'الترويج الرقمي لحملات التبرع عبر السوشال ميديا. إعداد محتوى جذاب وتحفيز المشاركة. تحديث البيانات والتفاعل مع المتبرعين. الجمع بين الإبداع والعمل الإنساني.',
                    'required_tasks' => 'إنشاء محتوى ترويجي، التواصل مع المتبرعين، تحديث قاعدة البيانات',
                    'location' => 'عن بُعد',
                    'volunteer_hours' => '5 ساعات أسبوعياً.',
                    'total_amount' => '8',
                    'current_amount' => '0',
                    'duration_type' => 'تطوعي',
                    'photo' => 'charity_logo/logo.png',

               ],
               [

                    'type_id' => 6,
                    'name' => 'تقديم دروس تعليمية عبر الإنترنت ',
                    'description' => 'تدريس الطلاب عن بُعد عبر المنصات التعليمية. تقديم دعم أكاديمي فردي وجماعي. تبسيط المفاهيم وتحسين المستوى الدراسي. تعزيز تفاعل الطلاب وتشجيعهم على النجاح.',
                    'required_tasks' => 'تحضير الدروس، تقديمها عبر منصات التعليم عن بُعد، متابعة تقدم الطلاب',
                    'location' => 'عن بُعد',
                    'volunteer_hours' => '3 ساعات أسبوعياً',
                    'total_amount' => '7',
                    'current_amount' => '0',
                    'duration_type' => 'تطوعي',
                    'photo' => 'charity_logo/logo.png',

               ],
               [

                    'type_id' => 1,
                    'name' => 'متابعة صحية للمسنين ',
                    'description' => 'زيارات دورية للاطمئنان على صحة المسنين. مراقبة المؤشرات الحيوية وتنظيم الأدوية. تقديم دعم نفسي وإنساني لكبار السن. الهدف تحسين جودة حياتهم وراحتهم.',
                    'required_tasks' => 'قياس الضغط، التأكد من أخذ الأدوية، تسجيل الملاحظات للطاقم الطبي.',
                    'location' => 'دار رعاية المسنين  حي المجتهد',
                    'volunteer_hours' => 'ساعتين.',
                    'total_amount' => '4 ',
                    'current_amount' => '0',
                    'duration_type' => 'تطوعي',
                    'photo' => 'charity_logo/logo.png',

               ],
               [

                    'type_id' => 1,
                    'name' => 'دعم نفسي للأطفال المصابين بأمراض مزمنة ',
                    'description' => 'تنظيم فعاليات ترفيهية ونفسية للأطفال المرضى. التخفيف من القلق والوحدة المرتبطة بالمرض. خلق بيئة آمنة للتعبير عن المشاعر. رفع معنوياتهم وتعزيز ثقتهم بأنفسهم.',
                    'required_tasks' => 'جلسات رسم، ألعاب جماعية، محادثات تحفيزية',
                    'location' => 'ريف دمشق ',
                    'volunteer_hours' => 'ساعات أسبوعياً.',
                    'total_amount' => '3',
                    'current_amount' => '0',
                    'duration_type' => 'تطوعي',
                    'photo' => 'charity_logo/logo.png',

               ]
          ];

          $permanent_projects = [
               [
                    'type_id' => 2,
                    'name' => 'دعم التعليم المستمر',
                    'description' => 'يهدف المشروع إلى دعم العملية التعليمية للأطفال والشباب من الأسر المحتاجة، '
                         . 'من خلال المساهمة في ترميم المدارس، تأمين المستلزمات الدراسية، '
                         . 'وتوفير فرص التعليم النوعي. تضاف جميع التبرعات إلى رصيد الجمعية لضمان الاستمرار في تعزيز التعليم العادل للجميع.',
                    'duration_type' => 'دائم',
                    'photo' => 'permanent_project_images/educational_project.png',
               ],
               [
                    'type_id' => 3,
                    'name' => 'مسكن كريم للجميع',
                    'description' => 'يسعى المشروع إلى المساهمة في تحسين الظروف السكنية للعائلات المحتاجة، '
                         . 'عبر دعم ترميم المنازل، تأمين الإيجارات أو بناء مساكن بسيطة. '
                         . ' تضاف التبرعات إلى رصيد الجمعية لدعم الحالات الأكثر حاجة في الجانب السكني بشكل دائم.',
                    'duration_type' => 'دائم',
                    'photo' => 'permanent_project_images/residential_project.png',
               ],
               [
                    'type_id' => 4,
                    'name' => 'غذاء دائم للمحتاجين',
                    'description' => 'يهدف المشروع إلى توفير الأمن الغذائي للفئات الأشد حاجة، '
                         . 'من خلال توزيع السلال الغذائية، وجبات الطعام، ودعم برنامج التغذية المستدامة. '
                         . 'تضاف جميع التبرعات إلى رصيد الجمعية لتغطية المبادرات الغذائية المستمرة.',
                    'duration_type' => 'دائم',
                    'photo' => 'permanent_project_images/food_project.png',
               ],

               [
                    'type_id' => 1,
                    'name' => 'رعاية صحية مستدامة',
                    'description' => 'يساهم المشروع في تقديم الرعاية الصحية للمحتاجين، '
                         . 'عبر دعم تكاليف العلاج، توفير الأدوية، '
                         . 'وإجراء الفحوصات الطبية الأساسية. '
                         . 'تضاف جميع التبرعات لرصيد الجمعية لدعم الحالات الصحية الطارئة والمزمنة بشكل دائم.',
                    'duration_type' => 'دائم',
                    'photo' => 'permanent_project_images/health_project.png',
               ],


          ];


          $temporary_projects = [
               [
                    'type_id' => 1,
                    'name' => 'رعاية صحية لمرضى السرطان',
                    'description' => 'يهدف هذا المشروع إلى تقديم الرعاية الصحية المتكاملة لمرضى السرطان،'
                         . ' من خلال دعم تكاليف العلاج،'
                         . ' وتوفير الأدوية اللازمة،'
                         . ' وتسهيل الوصول إلى الفحوصات الدورية'
                         . ' . نسعى لمد يد العون للمرضى من ذوي الدخل المحدود،'
                         . ' ومساندتهم في رحلتهم العلاجية،'
                         . ' بما يضمن لهم حياة كريمة وأملاً متجدداً في الشفاء.',
                    'photo' => 'temporary_projects_images/health_project_001.jpg',
                    'priority' => 'حرج',
                    'total_amount' => 8800
               ],
               [
                    'type_id' => 1,
                    'name' => 'تأمين مستلزمات صحية',
                    'description' => 'يهدف هذا المشروع لتأمين مستلزمات صحية ضرورية للمرضى،'
                         . ' مثل الأدوية، وأجهزة الرعاية المنزلية،'
                         . ' والمستلزمات الطبية الأساسية،'
                         . ' وذلك للمساهمة في تحسين ظروفهم الصحية،'
                         . ' وتخفيف العبء المادي عنهم وعن أسرهم،'
                         . ' خاصةً من هم في أمسّ الحاجة إلى الدعم.',
                    'photo' => 'temporary_projects_images/health_project_002.jpg',
                    'total_amount' => 5600
               ],
               [
                    'type_id' => 1,
                    'name' => 'تشخيص مجاني للمحتاجين',
                    'description' => 'يهدف هذا المشروع لتوفير خدمات تشخيص طبي مجاني للمحتاجين،'
                         . ' من خلال تأمين الفحوصات الطبية الأساسية،'
                         . ' وتحاليل المختبر، وصور الأشعة،'
                         . ' وذلك بهدف الكشف المبكر عن الأمراض وتقديم التوجيه الطبي المناسب،'
                         . ' مساهمةً في رعاية صحية عادلة وشاملة.',
                    'photo' => 'temporary_projects_images/health_project_003.jpg',
                    'total_amount' => 10000
               ],
               [
                    'type_id' => 1,
                    'name' => 'قوافل طبية متنقلة',
                    'description' => 'يهدف هذا المشروع إلى توفير خدمات طبية متنقلة تشمل الكشف،'
                         . ' التشخيص، والعلاج المجاني في المناطق النائية والقرى التي تفتقر إلى مرافق صحية مناسبة.'
                         . ' يعمل المشروع على تخفيف معاناة السكان الذين يصعب عليهم الوصول إلى المستشفيات،'
                         . ' من خلال تسيير سيارات طبية مجهزة بأطباء وفريق طبي متخصص.'
                         . ' كما يساهم في رفع مستوى الوعي الصحي والوقاية من'
                         . ' الأمراض من خلال التوعية والتثقيف المجتمعي أثناء الزيارات الدورية.',
                    'photo' => 'temporary_projects_images/health_project_004.jpg',
                    'total_amount' => 7400
               ],
               [
                    'type_id' => 1,
                    'name' => 'توفير أدوية مزمنة للمرضى الفقراء',
                    'description' => 'يهدف هذا المشروع إلى توفير الأدوية الأساسية والضرورية بشكل مستمر'
                         . ' ومجاني لمرضى الأمراض المزمنة من الفئات ذات الدخل المحدود.'
                         . ' يسعى المشروع إلى تحسين جودة حياة المرضى من خلال'
                         . ' ضمان حصولهم على العلاج الدوائي المنتظم،'
                         . ' مثل أدوية السكري، الضغط، والربو، دون الحاجة للقلق بشأن التكاليف المالية.'
                         . ' كما يساهم في تقليل المضاعفات الصحية'
                         . ' وزيادة فرص الشفاء أو السيطرة على المرض،'
                         . ' مما يخفف العبء عن المستشفيات والمراكز الصحية.',
                    'photo' => 'temporary_projects_images/health_project_005.jpg',
                    'total_amount' => 9800
               ],
               [
                    'type_id' => 1,
                    'name' => 'حملات تطعيم وقاية من الأمراض',
                    'description' => 'يهدف هذا المشروع إلى تنظيم حملات تطعيم واسعة'
                         . ' تستهدف الأطفال والنساء والفئات الأكثر عرضة للأمراض في المجتمعات الفقيرة والمناطق النائية.'
                         . ' يعمل المشروع على تعزيز المناعة المجتمعية والوقاية من انتشار الأمراض المعدية'
                         . ' من خلال توفير اللقاحات الأساسية بشكل مجاني وآمن.'
                         . ' كما يسعى إلى توعية المجتمع بأهمية التطعيم'
                         . ' ودوره في حماية الأفراد والعائلات من المخاطر الصحية،'
                         . ' وتحسين مستوى الصحة العامة على المدى الطويل.',
                    'photo' => 'temporary_projects_images/health_project_006.jpg',
                    'priority' => 'حرج',
                    'total_amount' => 3500
               ],
               [
                    'type_id' => 2,
                    'name' => 'ترميم المدارس في المناطق المتضررة',
                    'description' => 'يهدف هذا المشروع إلى ترميم المدارس في المناطق المتضررة،'
                         . ' من خلال إعادة تأهيل المباني،'
                         . ' وصيانة المرافق الأساسية، وتوفير بيئة تعليمية آمنة وصالحة للطلاب.'
                         . ' نسعى من خلال هذا الجهد إلى دعم استمرار العملية التعليمية للأطفال،'
                         . ' وتمكينهم من التعلم في ظروف كريمة تليق بحقهم في التعلم.',
                    'photo' => 'temporary_projects_images/educational_projects_001.jpg',
                    'total_amount' => 13850
               ],
               [
                    'type_id' => 2,
                    'name' => 'تأمين حقيبة متكاملة للطلاب',
                    'description' => 'يهدف هذا المشروع إلى تأمين حقيبة مدرسية متكاملة للطلاب،'
                         . ' تحتوي على جميع الأدوات والقرطاسية الأساسية التي يحتاجونها مع بداية العام الدراسي.'
                         . ' نسعى من خلال هذا الدعم إلى تخفيف الأعباء عن الأسر المحتاجة،'
                         . ' وتمكين أبنائهم من متابعة تعليمهم بثقة وكرامة،'
                         . ' في بيئة تعليمية مشجعة وعادلة.',
                    'photo' => 'temporary_projects_images/educational_projects_002.jpg',
                    'total_amount' => 2200
               ],
               [
                    'type_id' => 2,
                    'name' => 'تسيير نقل للطلاب في المناطق النائية',
                    'description' => 'يهدف هذا المشروع إلى تأمين وسائل نقل آمنة'
                         . ' ومنتظمة للطلاب في المناطق النائية،'
                         . ' لمساعدتهم على الوصول إلى مدارسهم بسهولة ودون انقطاع.'
                         . ' نسعى من خلال هذا الدعم إلى تقليل معدلات التسرب الدراسي،'
                         . ' وتوفير فرصة تعليم عادلة للأطفال في القرى والمناطق البعيدة،'
                         . ' بما يضمن استمرارهم في التعلم في بيئة مستقرة ومحفزة.',
                    'photo' => 'temporary_projects_images/educational_projects_003.jpg',
                    'total_amount' => 3140
               ],
               [
                    'type_id' => 2,
                    'name' => 'تطوير مهارات الحاسوب واللغات',
                    'description' => 'يهدف هذا المشروع إلى تقديم دورات تعليمية في'
                         . ' مهارات الحاسوب الأساسية وتعلم اللغات الأجنبية،'
                         . ' تستهدف الشباب والطلاب بشكل خاص.'
                         . ' يسعى المشروع إلى تمكين المشاركين من استخدام التكنولوجيا'
                         . ' بفعالية والتواصل بلغات متعددة،'
                         . ' مما يساهم في تعزيز فرصهم التعليمية والمهنية ضمن بيئة تفاعلية ومواكبة للتطورات الحديثة.',
                    'photo' => 'temporary_projects_images/educational_projects_004.jpg',
                    'total_amount' => 4300
               ],
               [
                    'type_id' => 2,
                    'name' => 'مدرسة متنقلة (سنة دراسية في حافلة)',
                    'description' => 'يهدف هذا المشروع إلى توفير التعليم للأطفال في المناطق النائية'
                         . ' من خلال حافلة مجهزة كفصل دراسي متنقل،'
                         . ' تقدم دروساً في المواد الأساسية بإشراف معلمين مؤهلين.'
                         . ' يُسهم المشروع في ضمان حق التعليم وتقليل التسرب الدراسي،'
                         . ' عبر بيئة تعليمية آمنة ومتنقلة تراعي احتياجات الأطفال في الظروف الصعبة.',
                    'photo' => 'temporary_projects_images/educational_projects_005.jpg',
                    'total_amount' => 3000
               ],
               [
                    'type_id' => 2,
                    'name' => 'دروس تقوية مجانية لطلاب الشهادات',
                    'description' => 'يهدف هذا المشروع إلى تقديم دروس تقوية مجانية لطلاب الشهادات الدراسية،'
                         . ' مثل الشهادة الإعدادية والثانوية،'
                         . ' في المواد الأساسية التي تشكّل تحدياً لهم.'
                         . ' يسعى المشروع إلى دعم الطلاب من الأسر ذات الدخل المحدود،'
                         . ' ورفع مستواهم الأكاديمي من خلال دروس منتظمة يقدمها مدرسون مختصون،'
                         . ' مما يساعدهم على تحسين نتائجهم وزيادة فرص نجاحهم في الامتحانات النهائية.',
                    'photo' => 'temporary_projects_images/educational_projects_001.jpg',
                    'total_amount' => 6300
               ],


               [
                    'type_id' => 3,
                    'name' => 'بناء مجمع طبي للمرضى المحتاجين',
                    'description' => 'يسعى المشروع إلى توفير الرعاية الصحية الأساسية مثل الفحوصات العامة، '
                         . 'متابعة الأمراض المزمنة، خدمات الأمومة والطفولة، '
                         . 'وتوفير الأدوية الأساسية، وذلك عبر كادر طبي مؤهل وتجهيزات حديثة. '
                         . 'كما يهدف المركز إلى تخفيف العبء عن المستشفيات الحكومية ودعم الاستقرار الصحي في المجتمع '
                         . 'من خلال الوصول إلى الفئات الأكثر ضعفاً واحتياجاً.',
                    'photo' => 'temporary_projects_images/residential_project_001.jpg',
                    'total_amount' => 130000
               ],
               [
                    'type_id' => 3,
                    'name' => 'بناء مرافق خدمية للمساجد',
                    'description' => 'يهدف هذا المشروع إلى بناء مرافق خدمية متكاملة تخدم المصلّين في الجامع، ' .
                         'مثل دورات المياه، أماكن الوضوء، وحدات تبريد أو تدفئة، ' .
                         'بالإضافة إلى مساحات مخصصة للنساء وكبار السن. ' .
                         'يسعى المشروع إلى تحسين تجربة المصلين وتوفير بيئة نظيفة ومريحة تليق بحرمة المكان، ' .
                         'كما يساهم في تعزيز دور الجامع كمركز روحي واجتماعي يخدم أهالي المنطقة.',
                    'photo' => 'temporary_projects_images/residential_project_002.jpg',
                    'total_amount' => 6300
               ],
               [
                    'type_id' => 3,
                    'name' => 'بناء مركز تأهيل لذوي الاحتياجات الخاصة',
                    'description' => 'يهدف هذا المشروع إلى بناء مركز متخصص لتأهيل ذوي الاحتياجات الخاصة، ' .
                         'يقدّم خدمات علاجية وتربوية وتأهيلية تُساهم في دمجهم في المجتمع وتحسين جودة حياتهم. ' .
                         'يوفّر المركز جلسات علاج طبيعي ونفسي، برامج تدريبية لتنمية المهارات الحركية والذهنية، ' .
                         'بالإضافة إلى دعم أسرهم وتمكينهم من التعامل مع التحديات اليومية. ' .
                         'كما يسعى المشروع إلى تعزيز مبدأ المساواة وتكافؤ الفرص، ' .
                         'من خلال توفير بيئة آمنة ومحفزة تراعي احتياجاتهم الخاصة باحترام وإنسانية.',
                    'photo' => 'temporary_projects_images/residential_project_003.jpg',
                    'total_amount' => 142000
               ],
               [
                    'type_id' => 3,
                    'name' => 'بناء حضانة للأطفال اليتامى',
                    'description' => 'يهدف هذا المشروع إلى إنشاء حضانة مخصصة للأطفال الأيتام، ' .
                         'توفّر لهم بيئة تربوية آمنة وداعمة في مرحلة الطفولة المبكرة. ' .
                         'يركز المشروع على تقديم الرعاية النفسية والتعليمية والغذائية لهؤلاء الأطفال، ' .
                         'بإشراف كادر مؤهل يهتم بتنمية مهاراتهم وتعزيز ثقتهم بأنفسهم. ' .
                         'كما يسعى المشروع إلى تعويض الأطفال عن جزء من الحنان والرعاية التي فقدوها، ' .
                         'وتمكينهم من بداية سليمة تبني لهم مستقبلاً مشرقاً بإذن الله.',
                    'photo' => 'temporary_projects_images/residential_project_004.jpg',
                    'total_amount' => 95000
               ],
               [
                    'type_id' => 3,
                    'name' => 'بناء مراكز صغيرة للتعليم',
                    'description' => 'يهدف هذا المشروع إلى إنشاء مراكز تعليمية صغيرة في المناطق النائية أو الفقيرة، ' .
                         'لتوفير بيئة تعليمية آمنة ومجهزة للأطفال الذين لا تتوفر لهم فرص التعليم الكافية. ' .
                         'تركز هذه المراكز على محو الأمية، تقوية المهارات الأساسية مثل القراءة والكتابة والحساب، ' .
                         'بالإضافة إلى دعم التعليم المبكر للأطفال. ' .
                         'كما تسعى لتوفير معلمين مؤهلين، ومستلزمات دراسية مناسبة، ' .
                         'من أجل دعم تنمية جيل واعٍ ومتعلم قادر على تحسين ظروفه وبناء مستقبله.',
                    'photo' => 'temporary_projects_images/residential_project_005.jpg',
                    'total_amount' => 135400
               ],


               [
                    'type_id' => 4,
                    'name' => 'إفطار صائم',
                    'description' => 'يهدف هذا المشروع إلى توزيع وجبات إفطار يومية على الصائمين في رمضان، ' .
                         'خاصة في المناطق الفقيرة ومواقع التجمعات مثل المساجد والمخيمات. ' .
                         'يساهم المشروع في تخفيف الأعباء المعيشية عن الأسر المحتاجة، ' .
                         'وتعزيز روح التكافل في الشهر الفضيل.',
                    'photo' => 'temporary_projects_images/nutritional_project_001.png',
                    'total_amount' => 4800
               ],
               [
                    'type_id' => 4,
                    'name' => 'مطبخ خيري متنقل',
                    'description' => 'يهدف هذا المشروع إلى إعداد وتوزيع وجبات ساخنة يومياً ' .
                         'أو أسبوعياً على الأفراد والأسر الأشد فقراً، ' .
                         'من خلال مطبخ متنقل يجوب المناطق المحتاجة. ' .
                         'يسهم المشروع في توفير وجبة غذائية صحية لمن لا يملك القدرة على الطهي أو شراء الطعام، ' .
                         'خصوصاً كبار السن والعائلات المتضررة.',
                    'photo' => 'temporary_projects_images/nutritional_project_002.png',
                    'total_amount' => 6700
               ],
               [
                    'type_id' => 7,
                    'name' => 'دعم حلقات تحفيظ القرآن',
                    'description' => 'يهدف هذا المشروع إلى دعم حلقات تحفيظ القرآن الكريم، ' .
                         'من خلال توفير الاحتياجات التعليمية والمادية للحلقات، ' .
                         'وتأمين بيئة مناسبة للحفظ والمراجعة، وتشجيع الطلاب على حفظ كتاب الله وتدبر معانيه. ' .
                         'نسعى إلى تعزيز القيم الإسلامية في نفوس النشء، ' .
                         'والمساهمة في بناء جيلٍ واعٍ متمسك بدينه وأخلاقه.',
                    'photo' => 'temporary_projects_images/religion_project_001.png',
                    'total_amount' => 4350
               ],
               [
                    'type_id' => 7,
                    'name' => 'تأمين المصاحف والكتب الشرعية',
                    'description' => 'يهدف هذا المشروع إلى توفير المصاحف والكتب الإسلامية المعتمدة وتوزيعها على المساجد، ' .
                         'المراكز التعليمية، حلقات التحفيظ، والمدارس الشرعية في المناطق المحتاجة. ' .
                         'يشمل المشروع طباعة وتوزيع نسخ من القرآن الكريم بأحجام مختلفة، ' .
                         'تأمين كتب التفسير، الحديث، الفقه، والسيرة النبوية.',
                    'photo' => 'temporary_projects_images/religion_project_002.png',
                    'total_amount' => 2900
               ],
               [
                    'type_id' => 7,
                    'name' => 'كفالة طالب علم شرعي',
                    'description' => 'يهدف هذا المشروع إلى دعم طلاب العلم الشرعي الغير قادرين على تحمّل نفقات دراستهم، ' .
                         'وذلك من خلال تقديم كفالات مالية شهرية تُعينهم على التفرّغ لطلب العلم، ' .
                         'وتغطي احتياجاتهم الأساسية من سكن، غذاء، ومستلزمات دراسية.',
                    'photo' => 'temporary_projects_images/religion_project_003.png',
                    'total_amount' => 68300
               ],


          ];


           $completed_projects = [
               [
                    'type_id' => 1,
                    'name' => 'زراعة قوقعة أذنية لطفلة تعاني من فقدان شديد في السمع ',
                    'description' => 'بعد تقييم دقيق وشامل لحالة الطفلة الصحية والسمعية، تم اتخاذ القرار الطبي بزراعة القوقعة كحل علاجي فعّال. تأتي هذه الخطوة لتفتح آفاقاً جديدة أمام الطفلة لاستعادة حاسة السمع، وتحسين مهارات النطق والتواصل، بما يضمن دمجها بشكل سلس في بيئتها التعليمية والاجتماعية، ويمهد لمستقبل أفضل.',
                    'photo' => 'completed_project_images/زراعة_قوقعة_اذنية.png',
                    'priority' => 'مرتفع',
                    'total_amount' => 10000,
                    'status' => 'منتهي'

               ],
               [
                    'type_id' => 1,
                    'name' => 'إجراء عملية زراعة قلب لطفل',
                    'description' => 'نجحت العملية بفضل الله، وبفضل الدعم الكريم من كل من تبرع وساهم في إنجاحها. تم تقديم الرعاية اللازمة لمتابعة تعافي الطفل وتحسين جودة حياته، مع متابعة طبية دقيقة لضمان استقرار حالته الصحية.',
                    'photo' => 'completed_project_images/زراعة_قلب_لطفل.jpg',
                    'priority' => 'حرج',
                    'total_amount' => 25000,
                    'status' => 'منتهي'
               ],
          ];


          foreach ($completed_projects as $project) {
               Project::create([
                    'type_id' => $project['type_id'],
                    'name' => $project['name'],
                    'description' => $project['description'],
                    'photo' => $project['photo'],
                    'priority' => $project['priority'],
                    'total_amount' => $project['total_amount'],
                    'status' => $project['status'],
        
               ]);
          }


          foreach ($volunteer_projects as $project) {
               Project::create([
                    'type_id' => $project['type_id'],
                    'name' => $project['name'],
                    'description' => $project['description'],
                    'required_tasks' => $project['required_tasks'],
                    'location' => $project['location'],
                    'volunteer_hours' => $project['volunteer_hours'],
                    'total_amount' => $project['total_amount'],
                    'current_amount' => $project['current_amount'],
                    'duration_type' => $project['duration_type'],
                    'photo' => $project['photo'],
               ]);
          }

          foreach ($temporary_projects as $project) {
               if (!array_key_exists('priority', $project)) {
                    $project['priority'] = 'متوسط';
               }
               Project::create([
                    'type_id' => $project['type_id'],
                    'name' => $project['name'],
                    'description' => $project['description'],
                    'total_amount' => $project['total_amount'],
                    'priority' => $project['priority'],
                    'photo' => $project['photo'],
               ]);
          }


          foreach ($permanent_projects as $project) {
               Project::create([
                    'type_id' => $project['type_id'],
                    'name' => $project['name'],
                    'description' => $project['description'],
                    'duration_type' => $project['duration_type'],
                    'photo' => $project['photo'],
               ]);
          }

          // beneficiary project

          Project::create([
               'user_id' => 5,
               'type_id' => 1,
               'name' => 'مساعدة صحية لأحد المحتاجين',
               'description' => 'محتاج بحاجة إلى مساعدة ببعض التحاليل والصور الطبية',
               'photo' => 'charity_logo/logo.png',
               'duration_type' => 'فردي',
               'current_amount' => 100,
               'total_amount' => 10000
          ]);
     }
}
