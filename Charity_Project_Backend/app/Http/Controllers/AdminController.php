<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AdminDonationHistory;
use App\Models\BeneficiaryRequest;
use App\Models\Charity;
use App\Models\Donation;
use App\Models\Feedback;
use App\Models\Notification;
use App\Models\Project;
use App\Models\Type;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\VolunteerRequest;
use Carbon\Carbon;
use GuzzleHttp\Handler\Proxy;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Mockery\Matcher\Not;
use PHPUnit\Framework\TestStatus\Notice;

use function PHPUnit\Framework\isNull;

class AdminController extends Controller
{
    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        }

        if ($admin->deleted) {
            return response()->json(['message' => 'this account was deleted by super admin'], 401);
        }
        $token = $admin->createToken('admin_token')->plainTextToken;

        return response()->json([
            'message' => 'Admin login successful',
            'admin'   => $admin,
            'token'   => $token,
        ]);
    }

    public function logoutAdmin(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin && $admin->currentAccessToken()) {
            $admin->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'Admin Logout successful']);
    }

    public function monthlyDonations()
    {
        // اذا اليوم اول الشهر بس كمان لازم شيك انو اخر مرة سحبت من العالم كان الشهر الماضي
        if (Carbon::now()->day === 1) {
            $users = User::where('monthly_donation', '!=', 0)->get();
            $charity = Charity::findOrFail(1);
            if ($charity->last_monthly_donation != null && Carbon::today()->isSameDay($charity->last_monthly_donation)) {
                return response()->json(['message' => 'you did monthly donation this month'], 200);
            }
            $charity->last_monthly_donation = Carbon::today();
            foreach ($users as $user) {
                if ($user->monthly_donation <= $user->balance) {
                    // edit balance and get points
                    $user->balance -= $user->monthly_donation;
                    $user->points += floor(5 * log(1 + $user->monthly_donation));
                    $user->save();

                    // notification that the monthly donation is done
                    $notification = [
                        'user_id' => $user->id,
                        'title' => 'التبرع الشهري',
                        'message' => 'تم تنفيذ التبرع الشهري بنجاح، نشكرك على التزامك المستمر بالعطاء'
                    ];
                    Notification::create($notification);

                    // add to donation history
                    $history = [
                        'user_id' => $user->id,
                        'type' => 'تبرع شهري',
                        'amount' => $user->monthly_donation,
                    ];
                    Donation::create($history);

                    // add money to somewhere

                    $donation_type = $user->monthly_donation_type;
                    $balanceMap = [
                        'صحي' => 'health_projects_balance',
                        'تعليمي' => 'educational_projects_balance',
                        'سكني' => 'housing_projects_balance',
                        'غذائي' => 'nutritional_projects_balance',
                        'ديني' => 'religious_projects_balance',
                    ];

                    if (!isset($balanceMap[$donation_type])) {
                        return response()->json(['message' => 'error has occurred'], 400);
                    }
                    $column = $balanceMap[$donation_type];
                    $charity->$column += $user->monthly_donation;

                    $charity->number_of_donations++;
                    $charity->save();
                } else {
                    // notification that he doesn't have enough money
                    $notification = [
                        'user_id' => $user->id,
                        'title' => 'التبرع الشهري',
                        'message' => 'تعذر تنفيذ التبرع الشهري لهذا الشهر بسبب عدم توافر رصيد كافي في محفظتك. يرجى إعادة الشحن لضمان استمرارية الدعم.'
                    ];
                    Notification::create($notification);
                }
            }
            $users = User::where('monthly_donation', 0)
                ->where('role', '!=', 'مستفيد')
                ->get();
            foreach ($users as $user) {
                // send notification to try monthly donation
                $notification = [
                    'user_id' => $user->id,
                    'title' => 'التبرع الشهري',
                    'message' => 'فعّل ميزة التبرع الشهري واجعل عطاءك مستمراً، في حال التفعيل سيتم سحب المبلغ الذي تحدده تلقائياً من محفظتك مع بداية كل شهر لدعم المحتاجين، بادر بتفعيلها الآن!'
                ];
                Notification::create($notification);
            }
            return response()->json(['message' => 'monthly donation has been payed for users who activated it, and notifications has been sent to users who did not activate it yet'], 200);
        }
        return response()->json(['message' => 'today is not the first of the month'], 400);
    }

    public function donateToProject(Request $request)
    {
        $validate = $request->validate([
            'amount' => 'required|numeric|min:1',
            'id' => 'required|exists:projects,id'
        ]);
        $admin = Auth::guard('admin')->user();
        $id = $request->id;
        $amount = $request->amount;
        $project = Project::findOrFail($id);
        $charity = Charity::findOrFail(1);

        if ($project->status !== 'جاري' || $project->duration_type === 'دائم' || $project->duration_type === 'تطوعي') {
            return response()->json(['message' => 'لا يمكن التبرع لهذا المشروع'], 400);
        }
        $project_type = $project->type->name;

        $type_map = [
            'صحي' => 'health_projects_balance',
            'تعليمي' => 'educational_projects_balance',
            'سكني' => 'housing_projects_balance',
            'غذائي' => 'nutritional_projects_balance',
            'ديني' => 'religious_projects_balance',
        ];

        if (!isset($type_map[$project_type])) {
            return response()->json(['message' => 'نوع المشروع خاطئ'], 400);
        }

        $column = $type_map[$project_type];

        if ($amount > $charity->$column) {
            return response()->json(['message' => 'ليس لديك رصيد كافٍ لإتمام هذه العملية، الرجاء شحن المحفظة وإعادة المحاولة.'], 400);
        }

        $remaining = $project->total_amount - $project->current_amount;
        $charity->$column -= min($amount, $remaining);
        $charity->save();

        $project->current_amount = min($project->current_amount + $amount, $project->total_amount);
        // check if project is completed
        if ($project->current_amount == $project->total_amount) {
            $project->status = 'منتهي';

            // if this project belongs to a beneficiary
            if ($project->duration_type === 'فردي') {
                $beneficiary = $project->user;
                // send notification to the beneficiary that his project has finished
                $notification = [
                    'user_id' => $beneficiary->id,
                    'title' => 'تم تمويل حالتك بالكامل',
                    'message' => 'تم تغطية حالتك بالكامل، وسيتم التواصل معك بأقرب وقت لتوصيل التبرعات، نسأل الله أن ييسر لك الأمور ويجزي المتبرعين خيراً.'
                ];
                Notification::create($notification);
            }

            // send notifications to all participated donors in this project
            $donors = $project->donations()->with('user')->get()->pluck('user')->unique('id');
            foreach ($donors as $donor) {
                $donor = User::findOrFail($donor->id);
                $notification = [
                    'user_id' => $donor->id,
                    'title' => 'تطورات جديدة في مشروع ' . $project->name,
                    'message' => 'بفضل الله ثم بفضلك وبفضل باقي المتبرعين، تم إتمام ' . $project->name . ' بالكامل، شكراً لدعمك المستمر🙏🏻',
                ];
                Notification::create($notification);
            }
        }
        $project->save();
        $history = [
            'admin_id' => $admin->id,
            'project_id' => $project->id,
            'amount' => min($amount, $remaining),
        ];
        AdminDonationHistory::create($history);
        return response()->json(['message' => 'تم التبرع لهذا المشروع بنجاح وسحب مبلغ ' . min($amount, $remaining) . '$ من رصيد الجمعية'], 200);
    }

    public function approveVolunteerRequest(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|exists:volunteer_requests,id',
        ]);
        $volunteer_request = VolunteerRequest::where('id', $request->id)->first();
        $user = $volunteer_request->user;
        // في غلط بالايدي ف المستخدم مو موجود
        if (is_null($user)) {
            return response()->json(['message' => 'حدث خطأ أثناء محاولة الوصول إلى هذا المستخدم، يرجى المحاولة لاحقاً'], 400);
        }
        // مالو باعت استبيان تطوع
        if (is_null($user->volunteer_status)) {
            return response()->json(['message' => 'هذا المستخدم ليس مسجلاً كمتطوع'], 400);
        }
        // هو بالاصل مقبول او مرفوض
        if ($user->volunteer_status !== 'معلق') {
            return response()->json(['message' => 'لا يمكنك قبول الطلب إن لم يكن معلقاً'], 400);
        }
        // قبول الطلب
        $user->volunteer_status = 'مقبول';
        $volunteer_request->volunteer_status = 'مقبول';
        $user->role = 'متطوع';
        $user->save();
        $volunteer_request->save();

        $notification = [
            'user_id' => $user->id,
            'title' => 'تحديث على طلب التطوع',
            'message' => 'تم قبول طلب تطوعكم معنا في الجمعية بنجاح! نتطلع قدماً لعملكم معنا✨'
        ];
        Notification::create($notification);

        return response()->json(['message' => 'تم قبول هذا المتطوع بنجاح'], 200);
    }

    public function rejectVolunteerRequest(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|exists:volunteer_requests,id',
        ]);
        $volunteer_request = VolunteerRequest::where('id', $request->id)->first();
        $user = $volunteer_request->user;
        // في غلط بالايدي ف المستخدم مو موجود
        if (is_null($user)) {
            return response()->json(['message' => 'حدث خطأ أثناء محاولة الوصول إلى هذا المستخدم، يرجى المحاولة لاحقاً'], 400);
        }
        // مالو باعت استبيان تطوع
        if (is_null($user->volunteer_status)) {
            return response()->json(['message' => 'هذا المستخدم ليس مسجلاً كمتطوع'], 400);
        }
        // هو بالاصل مقبول او مرفوض
        if ($user->volunteer_status !== 'معلق') {
            return response()->json(['message' => 'لا يمكنك رفض الطلب إن لم يكن معلقاً'], 400);
        }
        // رفض الطلب
        $user->volunteer_status = 'مرفوض';
        $volunteer_request->volunteer_status = 'مرفوض';
        $user->role = 'متبرع';
        $user->save();
        $volunteer_request->save();

        $notification = [
            'user_id' => $user->id,
            'title' => 'تحديث على طلب التطوع',
            'message' => 'شكراً على طلبك للتطوع معنا. نعتذر، لم يتم قبول طلبك. نقدّر اهتمامك ونتمنى لك التوفيق.'
        ];
        Notification::create($notification);

        return response()->json(['message' => 'تم رفض هذا الطلب بنجاح'], 200);
    }

    public function banVolunteer(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|exists:users,id',
        ]);
        $user = User::where('id', $request->id)->first();
        // في غلط ف المستخدم مو موجود
        if (is_null($user)) {
            return response()->json(['message' => 'حدث خطأ أثناء محاولة الوصول إلى المستخدم، يرجى المحاولة لاحقاً'], 400);
        }
        // مالو باعت استبيان تطوع
        if (is_null($user->volunteer_status)) {
            return response()->json(['message' => 'هذا المستخدم ليس مسجلاً كمتطوع'], 400);
        }
        // اذا كان حاظرو من قبل
        if ($user->ban) {
            return response()->json(['message' => 'لقد قمت بحظر هذا المتطوع من قبل'], 400);
        }
        // مالو مقبول
        if ($user->volunteer_status !== 'مقبول') {
            return response()->json(['message' => 'لا يمكنك حظر المتطوع إن لم يكن مقبولاً بعد'], 400);
        }
        // حظر المتطوع

        // $user->volunteer_status = 'مرفوض'; not needed cause $user->volunteer_status refers to the status of his last request and it must be 'مقبول'
        $user->ban = true;
        $user->is_working = false;
        $user->save();

        $notification = [
            'user_id' => $user->id,
            'title' => 'تحديث على حالة التطوع',
            'message' => 'تم إيقاف تطوعك في الجمعية بسبب مخالفات في تنفيذ المهام التطوعية، لمتابعة التفاصيل أو الاعتراض، يُرجى التواصل مع إدارة التطبيق على صفحة الفيسبوك الخاصة بالجمعية'
        ];
        Notification::create($notification);

        // احتمال يكون حاليا عم يشتغل بشي مشروع _ حاليا ماحعدل شي بهي الحالة

        return response()->json(['message' => 'تم حظر هذا المتطوع بنجاح'], 200);
    }

    public function unblockVolunteer(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|exists:users,id',
        ]);
        $user = User::where('id', $request->id)->first();
        // في غلط ف المستخدم مو موجود
        if (is_null($user)) {
            return response()->json(['message' => 'حدث خطأ أثناء محاولة الوصول إلى المستخدم، يرجى المحاولة لاحقاً'], 400);
        }
        // مالو باعت استبيان تطوع
        if (is_null($user->volunteer_status)) {
            return response()->json(['message' => 'هذا المستخدم ليس مسجلاً كمتطوع'], 400);
        }
        // اذا كان مو محظور
        if (!$user->ban) {
            return response()->json(['message' => 'هذا المتطوع غير محظور'], 400);
        }
        // فك حظر المتطوع
        $user->volunteer_status = 'مقبول';
        $user->ban = false;
        $user->save();

        $notification = [
            'user_id' => $user->id,
            'title' => 'تحديث على حالة التطوع',
            'message' => 'تم فك حظر التطوع الخاص بك، نتطلع لعودتك إلى العمل معنا✨'
        ];
        Notification::create($notification);

        return response()->json(['message' => 'تم فك الحظر عن هذا المتطوع بنجاح'], 200);
    }

    public function markVolunteerProjectAsCompleted(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|exists:projects,id'
        ]);
        $id = $request->id;
        $project = Project::Find($id);
        if ($project->duration_type !== 'تطوعي') {
            return response()->json(['message' => 'هذا المشروع ليس مشروعاً تطوعياً'], 400);
        }
        if ($project->status === 'منتهي') {
            return response()->json(['message' => 'تم تحديد هذا المشروع كمنتهي مسبقاً'], 400);
        }
        $volunteers = $project->volunteers;
        foreach ($volunteers as $volunteer) {
            $volunteer->is_working = false;
            $notification = [
                'user_id' => $volunteer->id,
                'title' => 'انتهاء مشروع التطوع',
                'message' => 'انتهى مشروع التطوع ' . $project->name . ' الذي كنت مشاركاً به، شكراً لعطائك🙏🏻'
            ];
            Notification::create($notification);
            $volunteer->save();
        }
        $project->status = 'منتهي';
        $project->save();
        return response()->json(['message' => 'تم تغيير حالة هذا المشروع إلى مشروع منتهي'], 200);
    }

    public function acceptBeneficiaryRequest(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|exists:beneficiary_requests,id'
        ]);
        $id = $request->id;
        $beneficiary_request = BeneficiaryRequest::find($id);
        $beneficiary = $beneficiary_request->user;
        // هو بالاصل مقبول او مرفوض
        if ($beneficiary_request->status !== 'معلق') {
            return response()->json(['message' => 'لا يمكنك قبول الطلب إن لم يكن معلقاً'], 400);
        }
        // قبول الطلب
        $beneficiary_request->status = 'مقبول';
        $beneficiary_request->save();

        $notification = [
            'user_id' => $beneficiary->id,
            'title' => 'تحديث على حالة طلبك',
            'message' => 'تم قبول طلب المساعدة الخاص بك، سيتم جمع التبرعات لحالتك بأقرب وقت وسنوافيك بالتفاصيل قريباً✨'
        ];
        Notification::create($notification);
    }

    public function rejectBeneficiaryRequest(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|exists:beneficiary_requests,id'
        ]);
        $id = $request->id;
        $beneficiary_request = BeneficiaryRequest::find($id);
        $beneficiary = $beneficiary_request->user;
        // هو بالاصل مقبول او مرفوض
        if ($beneficiary_request->status !== 'معلق') {
            return response()->json(['message' => 'لا يمكنك رفض الطلب إن لم يكن معلقاً'], 400);
        }
        // رفض الطلب
        $beneficiary_request->status = 'مرفوض';
        $beneficiary_request->save();

        $notification = [
            'user_id' => $beneficiary->id,
            'title' => 'تحديث على حالة طلبك',
            'message' => 'نعتذر، تم رفض الطلب الخاص بك لأسباب تتعلق بمدى مصداقية المعلومات والوثائق المدخلة.'
        ];
        Notification::create($notification);
    }

    public function banBeneficiary(Request $request)
    {
        $validate = $request->validate([
            'phone_number' => 'required|string|exists:users,phone_number'
        ]);
        $beneficiary = User::where('phone_number', $request->phone_number)->first();
        if ($beneficiary->role !== 'مستفيد') {
            return response()->json(['message' => 'لا يوجد مستفيد بهذا الرقم'], 400);
        }
        if ($beneficiary->ban) {
            return response()->json(['message' => 'تم حظر هذا المحتاج سابقاً'], 400);
        }
        // اذا المحتاج عندو مشروع جاري حاليا مارح خلي الادمن يحظرو ليخلص المشروع
        $project = Project::where('user_id', $beneficiary->id)
            ->where('status', 'جاري')
            ->get();
        if (!$project->isEmpty()) {
            return response()->json(['message' => 'لا يمكنك حظر المستخدم بسبب وجود مشروع باسمه، الرجاء الانتظار إلى حين اكتمال المشروع ثم المحاولة بعدها.'], 400);
        }
        $beneficiary->ban = true;
        $beneficiary->save();
        return response()->json(['message' => 'تم حظر هذا المحتاج بنجاح'], 200);
    }

    public function unblockBeneficiary(Request $request)
    {
        $validate = $request->validate([
            'phone_number' => 'required|string|exists:users,phone_number'
        ]);
        $beneficiary = User::where('phone_number', $request->phone_number)->first();
        if ($beneficiary->role !== 'مستفيد') {
            return response()->json(['message' => 'لا يوجد مستفيد بهذا الرقم'], 400);
        }
        if (!$beneficiary->ban) {
            return response()->json(['message' => 'هذا المحتاج غير محظور'], 400);
        }
        $beneficiary->ban = false;
        $beneficiary->save();
        return response()->json(['message' => 'تم فك حظر هذا المحتاج بنجاح'], 200);
    }

    public function giftDelivered(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|exists:donations,id'
        ]);
        $id = $request->id;
        $donation = Donation::find($id);
        if ($donation->type !== 'هدية') {
            return response()->json(['message' => 'حدث خطأ، لم يتم العثور على هذه الهدية'], 400);
        }
        if ($donation->delivered) {
            return response()->json(['message' => 'تم تسليم هذه الهدية سابقاً'], 400);
        }
        $donor = $donation->user;
        $beneficiary = User::where('phone_number', $donation->recipient_number)->first();

        $donor_notification = [
            'user_id' => $donor->id,
            'title' => 'تم تسليم الهدية',
            'message' => 'تم تسليم هديتك إلى ' . $donation->recipient_name . ' بنجاح هذا اليوم، شكراً لمساعدتك التي كانت سبباً في رسم البسمة اليوم🙏🏻'
        ];

        $beneficiary_notification = [
            'user_id' => $beneficiary->id,
            'title' => 'تم تسليم الهدية',
            'message' => 'تم تسليم هديتك إليك اليوم بنجاح، نأمل أن تكون سبباً في رسم البسمة على  وجهك✨'
        ];

        Notification::create($donor_notification);
        Notification::create($beneficiary_notification);

        $donation->delivered = true;
        $donation->save();

        return response()->json(['message' => 'تم تعديل حالة الهدية إلى (تم التسليم) بنجاح'], 200);
    }

    public function acceptFeedback(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|exists:feedback,id'
        ]);
        $id = $request->id;
        $feedback = Feedback::find($id);
        if ($feedback->status !== 'معلق') {
            return response()->json(['message' => 'لا يمكنك قبول التعليق إن لم يكن معلقاً'], 400);
        }
        $feedback->status = 'مقبول';
        $feedback->save();

        return response()->json(['message' => 'تم قبول هذا التعليق وسيتم عرضه في التطبيق للمتبرعين'], 200);
    }

    public function rejectFeedback(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|exists:feedback,id'
        ]);
        $id = $request->id;
        $feedback = Feedback::find($id);
        if ($feedback->status !== 'معلق') {
            return response()->json(['message' => 'لا يمكنك رفض التعليق إن لم يكن معلقاً'], 400);
        }
        $feedback->status = 'مرفوض';
        $feedback->save();

        return response()->json(['message' => 'تم رفض هذا التعليق بنجاح'], 200);
    }


    //الاحصائيات

    public function getStatistics()
    {
        $charity = Charity::first();

        $health_projects_balance = $charity->health_projects_balance;
        $educational_projects_balance = $charity->educational_projects_balance;
        $nutritional_projects_balance = $charity->nutritional_projects_balance;
        $housing_projects_balance = $charity->housing_projects_balance;
        $religious_projects_balance = $charity->religious_projects_balance;

        return response()->json([
            'total_donations' => Donation::sum('amount'),
            'accepted_volunteers' => User::where('role', 'متطوع')
                ->where('volunteer_status', 'مقبول')
                ->where('ban', false)
                ->count(),
            'beneficiaries' => User::where('role', 'مستفيد')->where('ban', false)->count(),
            'donors' => User::where('role', 'متبرع')->count(),
            'projects_count' => Project::count(),

            'health_projects_balance' => $health_projects_balance,
            'educational_projects_balance' => $educational_projects_balance,
            'nutritional_projects_balance' => $nutritional_projects_balance,
            'housing_projects_balance' => $housing_projects_balance,
            'religious_projects_balance' => $religious_projects_balance,
        ]);
    }

    //فلترة المشاريع

    public function getProjectsByType($typeName)
    {
        $type = Type::where('name', $typeName)->first();

        if ($type) {
            $projects = Project::where('type_id', $type->id)->get();

            return response()->json($projects, 200);
        } else {
            return response()->json(['message' => 'لا يوجد نوع بهذا الاسم'], 404);
        }
    }


    // فلترة طلبات التطوع (مقبول - مرفوض - معلق)
    public function getVolunteerRequestsByStatus($status)
    {
        $query = VolunteerRequest::query();

        if (!empty($status)) {
            $query->where('volunteer_status', $status);
        }

        $volunteers = $query->get([
            'id',
            'user_id',
            'full_name',
            'phone_number',
            'age',
            'volunteer_status',
            'place_of_residence',
            'gender',
            'your_last_educational_qualification',
            'your_studying_domain',
            'volunteering_hours',
            'purpose_of_volunteering',
        ]);

        return response()->json($volunteers, 200);
    }



    // فلترة المتطوعين محظور او لا

    public function filterVolunteersByBan($banned)
    {
        $query = User::query();

        $query->where('role', 'متطوع');

        if ($banned === 'true') {
            $query->where('ban', true);
        } elseif ($banned === 'false') {
            $query->where('ban', false);
        } else {
            return response()->json([
                'error' => 'قيمة غير صحيحة للحقل banned، استخدم true أو false فقط.'
            ], 400);
        }

        $volunteers = $query->get();

        foreach ($volunteers as $volunteer) {
            $volunteer['phone_number'] = VolunteerRequest::where('user_id', $volunteer->id)
                ->where('volunteer_status', 'مقبول')
                ->value('phone_number');
        }

        return response()->json($volunteers);
    }


    //فلترة المستفيدين لمحظور او لا
    public function filterBeneficiaryByBan($banned)
    {
        if ($banned === 'true') {
            $isBanned = true;
        } elseif ($banned === 'false') {
            $isBanned = false;
        } else {
            return response()->json([
                'error' => 'قيمة غير صحيحة للحقل banned، استخدم true أو false فقط.'
            ], 400);
        }

        $beneficiaries = User::where('role', 'مستفيد')
            ->where('ban', $isBanned)
            ->get(['full_name', 'email', 'phone_number', 'ban']);

        return response()->json($beneficiaries, 200);
    }

    public function getFilteredBeneficiaryRequests($type, $status)
    {
        $query = BeneficiaryRequest::with('type');

        if ($type) {
            $typeModel = Type::where('name', $type)->first();
            if ($typeModel) {
                $query->where('type_id', $typeModel->id);
            } else {
                return response()->json([]);
            }
        }

        if ($status) {
            $query->where('status', $status);
        }

        $requests = $query->get();

        return response()->json($requests);
    }


    // فلترة هدايا
    public function getFilteredGiftDelivered($delivered)
    {
        $query = Donation::where('type', 'هدية');

        if (!is_null($delivered)) {
            if ($delivered === 'true') {
                $query->where('delivered', true);
            } elseif ($delivered === 'false') {
                $query->where('delivered', false);
            } else {
                return response()->json([
                    'error' => 'قيمة غير صحيحة للحقل delivered، استخدم true أو false فقط.'
                ], 400);
            }
        }

        $donations = $query->with(['user:id,full_name,email'])->get();

        $filtered = $donations->map(function ($donation) {
            return [
                'id'               => $donation->id,
                'recipient_name'   => $donation->recipient_name,
                'recipient_number' => $donation->recipient_number,
                'amount'           => $donation->amount,
                'delivered'        => $donation->delivered,
                'full_name'        => optional($donation->user)->full_name,
                'email'            => optional($donation->user)->email,
            ];
        });

        return response()->json($filtered);
    }



    public function getFilteredFeedbacks($status)
    {
        $allowedStatuses = ['معلق', 'مقبول', 'مرفوض'];

        if ($status && !in_array($status, $allowedStatuses)) {
            return response()->json([
                'error' => 'قيمة غير صحيحة للحالة. استخدم: معلق، مقبول، مرفوض فقط.'
            ], 400);
        }


        $query = Feedback::query();

        if ($status) {
            $query->where('status', $status);
        }

        $feedbacks = $query->get(['id', 'user_name', 'message', 'status', 'created_at']);

        return response()->json($feedbacks, 200);
    }


    public function showBeneficiaryRequest(Request $request)
    {
        $id = $request->input('id');

        $beneficiaryRequest = BeneficiaryRequest::with(['type', 'user', 'supplies'])->find($id);

        if (!$beneficiaryRequest) {
            return response()->json(['message' => 'الطلب غير موجود'], 404);
        }

        return response()->json([
            'id' => $beneficiaryRequest->id,
            'full_name' => $beneficiaryRequest->full_name,
            'phone_number' => $beneficiaryRequest->phone_number,
            'age' => $beneficiaryRequest->age,
            'gender' => $beneficiaryRequest->gender,
            'user' => [
                'id' => optional($beneficiaryRequest->user)->id,
                'full_name' => optional($beneficiaryRequest->user)->full_name,
                'email' => optional($beneficiaryRequest->user)->email,
            ],
            'type' => optional($beneficiaryRequest->type)->name,
            'supplies' => $beneficiaryRequest->supplies->pluck('name'),
            'marital_status' => $beneficiaryRequest->marital_status,
            'number_of_kids' => $beneficiaryRequest->number_of_kids,
            'kids_description' => $beneficiaryRequest->kids_description,
            'governorate' => $beneficiaryRequest->governorate,
            'home_address' => $beneficiaryRequest->home_address,
            'monthly_income' => $beneficiaryRequest->monthly_income,
            'current_job' => $beneficiaryRequest->current_job,
            'monthly_income_source' => $beneficiaryRequest->monthly_income_source,
            'number_of_needy' => $beneficiaryRequest->number_of_needy,
            'expected_cost' => $beneficiaryRequest->expected_cost,
            'description' => $beneficiaryRequest->description,
            'severity_level' => $beneficiaryRequest->severity_level,
            'document_path' => $beneficiaryRequest->document_path ? asset('storage/' . $beneficiaryRequest->document_path) : null,
            'current_housing_condition' => $beneficiaryRequest->current_housing_condition,
            'needed_housing_help' => $beneficiaryRequest->needed_housing_help,
            'status' => $beneficiaryRequest->status,
            'created_at' => optional($beneficiaryRequest->created_at)->toDateTimeString(),
            'updated_at' => optional($beneficiaryRequest->updated_at)->toDateTimeString(),
        ]);
    }



    public function filterProjectByStatus($status)
    {
        if (!in_array($status, ['جاري', 'معلق', 'منتهي', 'محذوف'])) {
            return response()->json([
                'message' => 'الحالة غير موجوة.',
            ], 422);
        }

        $projects = Project::where('status', $status)->get();

        return response()->json($projects);
    }

    public function getProjectsByFilters(Request $request)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['جاري', 'معلق', 'منتهي', 'محذوف'])],
            'priority' => ['required', 'string', Rule::in(['منخفض', 'متوسط', 'مرتفع', 'حرج', 'الكل'])],
            'type' => ['required', 'string', Rule::in(['الكل', 'صحي', 'تعليمي', 'سكني', 'ديني', 'غذائي', 'ميداني', 'عن بعد'])],
            'duration_type' => ['required', 'string', Rule::in(['الكل', 'مؤقت', 'دائم', 'فردي', 'تطوعي'])],
        ]);
        $projects = Project::query()
            ->where('status', $validated['status'])

            ->when($validated['type'] !== 'الكل', function ($query) use ($validated) {
                $type_id = Type::where('name', $validated['type'])->first()?->id;
                if ($type_id) {
                    $query->where('type_id', $type_id);
                }
            })

            ->when($validated['priority'] !== 'الكل', function ($query) use ($validated) {
                $query->where('priority', $validated['priority']);
            })

            ->when($validated['duration_type'] !== 'الكل', function ($query) use ($validated) {
                $query->where('duration_type', $validated['duration_type']);
            })

            ->get();

        foreach ($projects as $project) {
            $project['photo_url'] = asset(Storage::url($project->photo));
            if ($project['duration_type'] === 'تطوعي') {
                $project['volunteers_list'] = $project->users->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->full_name,
                        'email' => $user->email,
                        'role' => $user->role,
                        'volunteer_status' => $user->volunteer_status,
                        'is_working' => $user->is_working,
                        'blocked' => $user->ban
                    ];
                });
            }
            unset($project->users);
        }
        return response()->json($projects);
    }


    // ***************** SUPER ADMIN FUNCTIONS

    public function superAdminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        }

        if (!$admin->is_super_admin) {
            return response()->json(['message' => 'Unauthorized: super admin access only'], 403);
        }

        $token = $admin->createToken('admin_token')->plainTextToken;

        return response()->json([
            'message' => 'Super Admin login successful',
            'admin'   => $admin,
            'token'   => $token,
        ]);
    }

    public function superAdminLogout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin && $admin->currentAccessToken()) {
            $admin->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'Super Admin Logout successful']);
    }

    public function addAdmin(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:40',
            'email' => 'required|string|email|unique:admins,email|max:40',
            'password' => 'required|string|min:5|confirmed',
        ]);
        $admin = Admin::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        return response()->json($admin, 201);
    }

    public function blockAdmin(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|exists:admins,id',
        ]);

        $admin = Admin::where('id', $request->id)->first();
        // في غلط ف المستخدم مو موجود
        if (is_null($admin)) {
            return response()->json(['message' => 'حدث خطأ أثناء محاولة الوصول إلى الأدمن، يرجى المحاولة لاحقاً'], 400);
        }
        // اذا كان حاظرو من قبل
        if ($admin->deleted) {
            return response()->json(['message' => 'لقد قمت بحظر هذا الأدمن من قبل'], 400);
        }
        if ($admin->is_super_admin) {
            return response()->json(['message' => 'لا يمكن حظر السوبر أدمن'], 400);
        }
        // حظر الأدمن
        $admin->deleted = true;
        $admin->save();
        return response()->json(['message' => 'تم حظر هذا الأدمن بنجاح'], 200);
    }

    public function unblockAdmin(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|exists:admins,id',
        ]);

        $admin = Admin::where('id', $request->id)->first();
        // في غلط ف المستخدم مو موجود
        if (is_null($admin)) {
            return response()->json(['message' => 'حدث خطأ أثناء محاولة الوصول إلى الأدمن، يرجى المحاولة لاحقاً'], 400);
        }
        // اذا ما كان حاظرو من قبل
        if (!$admin->deleted) {
            return response()->json(['message' => 'هذا الأدمن غير محظور مسبقاً'], 400);
        }
        if ($admin->is_super_admin) {
            return response()->json(['message' => 'لا يمكن حظر أو فك حظر السوبر أدمن'], 400);
        }
        // فك حظر الأدمن
        $admin->deleted = false;
        $admin->save();
        return response()->json(['message' => 'تم فك حظر هذا الأدمن بنجاح'], 200);
    }

    public function filterAdminsByBan($banned)
    {
        if ($banned === 'true') {
            $isBanned = true;
        } elseif ($banned === 'false') {
            $isBanned = false;
        } else {
            return response()->json([
                'error' => 'قيمة غير صحيحة للحقل banned، استخدم true أو false فقط.'
            ], 400);
        }

        $admins = Admin::where('is_super_admin', false)
            ->where('deleted', $isBanned)
            ->get();

        return response()->json($admins, 200);
    }
}
