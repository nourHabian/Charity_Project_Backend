<?php

namespace App\Http\Controllers;

use App\Http\Requests\BeneficiaryEducationalRequest;
use App\Http\Requests\BeneficiaryFoodRequest;
use App\Http\Requests\BeneficiaryHealthRequest;
use App\Http\Requests\BeneficiaryResidentialRequest;
use App\Models\BeneficiaryRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Notification;
use App\Models\RequestedSupply;
use App\Models\Supply;
use App\Models\Type;

class BeneficiaryRequestController extends Controller
{

    public function register(Request $request)
    {
        $validate = $request->validate([
            'full_name' => 'required|string|max:40',
            'email' => 'required|string|email|unique:users,email|max:40',
            'password' => 'required|string|min:5|confirmed',
            'phone_number' => 'required|string|unique:users,phone_number|max:10',

        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => 'مستفيد'
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $loginData['email'])->first();
        if (!$user || !Hash::check($loginData['password'], $user->password)) {
            return response()->json(['message' => 'بيانات الدخول غير صحيحة'], 401);
        }
        if ($user->ban) {
            return response()->json(['message' => 'تم حظر حسابك، يمكنك التواصل مع إدارة الجمعية'], 403);
        }

        if ($user->role !== 'مستفيد') {
            return response()->json(['message' => 'غير مسموح للمتبرعين بتسجيل الدخول'], 403);
        }
        $token = $user->createToken('auth_Token')->plainTextToken;
        return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout successful']);
    }


    /*public function getBeneficiaryRequest(Request $request)
    {
        
        if ($typeName === 'صحية' && $user->role === 'مستفيد') {
            
        } elseif ($typeName === 'سكنية' && $user->role === 'مستفيد') {
            $extraquestion = [
            ];
        } elseif ($typeName === 'تعليمية' && $user->role === 'مستفيد') {
            $extraquestion = [
                'number_of_needy' => 'required|integer|min:1|max:20',
                'educational_needs' => 'required|array|min:1',
                'educational_needs.*' => 'string|max:255',
                'expected_cost' => 'nullable|numeric|min:0',
                'description' => 'required|string|max:1000',
            ];
        } elseif ($typeName === 'غذائية' && $user->role === 'مستفيد') {
            $extraquestion = [
                'expected_cost' => 'nullable|numeric|min:0',
                'description' => 'required|string|max:1000',
                'special_nutritional_needs' => 'nullable|string|max:500',
            ];
        }
        //لحتى يصيرو الاسئلة الاساسية مع الاسئلة حسب النوع مدموجين سوا
        $validatedExtra = $request->validate($extraquestion);
        $allData = array_merge($validatedData, $validatedExtra);
        $allData['user_id'] = Auth::id();
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('beneficiary_documents', $filename, 'public');
            $allData['document_path'] = $path;
        }

        $requestRecord = BeneficiaryRequest::create($allData);

        return response()->json([
            'message' => 'تم إرسال طلب المساعدة بنجاح',
            'request_id' => $requestRecord->id
        ], 201);
    }*/

    public function submitHealthRequest(BeneficiaryHealthRequest $request)
    {
        $user = Auth::user();
        $lastRequest = BeneficiaryRequest::where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        if ($lastRequest) {
            $daysSinceLast = now()->diffInDays($lastRequest->created_at);
            if ($daysSinceLast < 20) {
                return response()->json([
                    'message' => 'لا يمكنك تقديم طلب جديد قبل مرور 20 يوم على آخر طلب تم تقديمه.',
                    'days_remaining' => 20 - $daysSinceLast
                ], 400);
            }
        }

        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();
        $validatedData['type_id'] = Type::where('name', 'صحي')->first()->id;

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('beneficiary_documents', $filename, 'public');
            $validatedData['document_path'] = $path;
            unset($validatedData['document']);
        }

        $notification = [
            'user_id' => $user->id,
            'title' => 'متابعة طلب المساعدة',
            'message' => 'تم إرسال طلب مساعدتك بنجاح، سيتم مراجعتها وإعلامك بالتحديثات بأقرب وقت، شكراً لثقتك بنا'
        ];
        Notification::create($notification);

        $requestRecord = BeneficiaryRequest::create($validatedData);
        return response()->json([
            'message' => 'تم إرسال طلب المساعدة الصحية بنجاح',
            'request_id' => $requestRecord->id
        ], 201);
    }

    public function submitResidentialRequest(BeneficiaryResidentialRequest $request)
    {
        $user = Auth::user();
        $lastRequest = BeneficiaryRequest::where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        if ($lastRequest) {
            $daysSinceLast = now()->diffInDays($lastRequest->created_at);
            if ($daysSinceLast < -1) {
                return response()->json([
                    'message' => 'لا يمكنك تقديم طلب جديد قبل مرور 20 يوم على آخر طلب تم تقديمه.',
                    'days_remaining' => 20 - $daysSinceLast
                ], 400);
            }
        }

        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();
        $validatedData['type_id'] = Type::where('name', 'سكني')->first()->id;

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('beneficiary_documents', $filename, 'public');
            $validatedData['document_path'] = $path;
            unset($validatedData['document']);
        }
        $notification = [
            'user_id' => $user->id,
            'title' => 'متابعة طلب المساعدة',
            'message' => 'تم إرسال طلب مساعدتك بنجاح، سيتم مراجعتها وإعلامك بالتحديثات بأقرب وقت، شكراً لثقتك بنا'
        ];
        Notification::create($notification);

        $requestRecord = BeneficiaryRequest::create($validatedData);
        return response()->json([
            'message' => 'تم إرسال طلب المساعدة السكنية بنجاح',
            'request_id' => $requestRecord->id
        ], 201);
    }

    public function submitFoodRequest(BeneficiaryFoodRequest $request) 
    {
        $user = Auth::user();
        $lastRequest = BeneficiaryRequest::where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        if ($lastRequest) {
            $daysSinceLast = now()->diffInDays($lastRequest->created_at);
            if ($daysSinceLast < 20) {
                return response()->json([
                    'message' => 'لا يمكنك تقديم طلب جديد قبل مرور 20 يوم على آخر طلب تم تقديمه.',
                    'days_remaining' => 20 - $daysSinceLast
                ], 400);
            }
        }

        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();
        $validatedData['type_id'] = Type::where('name', 'غذائي')->first()->id;

        unset($validatedData['needed_food_help']);
        $requestRecord = BeneficiaryRequest::create($validatedData);  
        $supplyIds = Supply::whereIn('name', $request->needed_food_help)->pluck('id')->toArray();     
        
        $notification = [
            'user_id' => $user->id,
            'title' => 'متابعة طلب المساعدة',
            'message' => 'تم إرسال طلب مساعدتك بنجاح، سيتم مراجعتها وإعلامك بالتحديثات بأقرب وقت، شكراً لثقتك بنا'
        ];
        Notification::create($notification);

        $requestRecord->supplies()->attach($supplyIds);
        return response()->json([
            'message' => 'تم إرسال طلب المساعدة الغذائية بنجاح',
            'request_id' => $requestRecord->id
        ], 201);
    }

    public function submitEducationalRequest(BeneficiaryEducationalRequest $request) 
    {
        $user = Auth::user();
        $lastRequest = BeneficiaryRequest::where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        if ($lastRequest) {
            $daysSinceLast = now()->diffInDays($lastRequest->created_at);
            if ($daysSinceLast < 20) {
                return response()->json([
                    'message' => 'لا يمكنك تقديم طلب جديد قبل مرور 20 يوم على آخر طلب تم تقديمه.',
                    'days_remaining' => 20 - $daysSinceLast
                ], 400);
            }
        }

        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();
        $validatedData['type_id'] = Type::where('name', 'تعليمي')->first()->id;

        unset($validatedData['needed_educational_help']);
        $requestRecord = BeneficiaryRequest::create($validatedData);  
        $supplyIds = Supply::whereIn('name', $request->needed_educational_help)->pluck('id')->toArray();     
        
        $notification = [
            'user_id' => $user->id,
            'title' => 'متابعة طلب المساعدة',
            'message' => 'تم إرسال طلب مساعدتك بنجاح، سيتم مراجعتها وإعلامك بالتحديثات بأقرب وقت، شكراً لثقتك بنا'
        ];
        Notification::create($notification);
        
        $requestRecord->supplies()->attach($supplyIds);
        return response()->json([
            'message' => 'تم إرسال طلب المساعدة التعليمية بنجاح',
            'request_id' => $requestRecord->id
        ], 201);
    }
}
