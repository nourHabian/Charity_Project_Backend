<?php

namespace App\Http\Controllers;

use App\Models\BeneficiaryRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Notification;
use App\Models\Type;

class BeneficiaryRequestController extends Controller
{

    public function register(Request $request)
    {
            $validate = $request->validate([
                'full_name' => 'required|string|max:40',
                'email' => 'required|string|email|unique:users,email|max:40',
                'password' => 'required|string|min:5|confirmed',
                'phone_number' =>'required|string|unique:users,phone_number|max:10',
                
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
                if($user->ban){
                    return response()->json(['message' => 'تم حظر حسابك، يمكنك التواصل مع إدارة الجمعية'], 403);
                }

                if ($user->role !=='مستفيد') {
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


            public function getBeneficiaryRequest(Request $request)
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
                ], 403);
                }
            }


            $commonquestion = [
                'full_name' => 'required|string|max:100',
                'age' => 'required|integer|min:1|max:120',
                'gender' => 'required|in:ذكر,أنثى',
                'marital_status' => 'required|in:أعزب,متزوج,مطلق,أرمل',
                'phone_number' => 'required|string|max:15',
                'number_of_kids' => 'nullable|integer|min:0|max:20',
                'kids_description' => 'nullable|string|max:1000',
                'city' => 'required|string|max:100',
                'home_address' => 'required|string|max:255',
                'monthly_income' => 'required|numeric|min:0',
                'current_job' => 'nullable|string|max:100',
                'monthly_income_source' => 'required|numeric|min:0',
                'is_taking_donations' => 'required|string|in:نعم,لا',
                'other_donations_sources' => 'nullable|string|max:255',
                'type_id' => 'required|exists:types,id', // نوع المساعدة
            ];

            $validatedData = $request->validate($commonquestion);
            $typeId = $validatedData['type_id'];
            $typeName = Type::find($typeId)?->name;
            $extraquestion = [];

            if ($typeName === 'صحية' && $user->role ==='مستفيد') {
                    $extraquestion = [
                        'severity_level' => 'required|in:اسعافي,مستعجل,عادي',
                        'document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                        'expected_cost' => 'nullable|numeric|min:0',
                        'description' => 'required|string|max:1000',
                    ];
                }

            elseif ($typeName === 'سكنية' && $user->role ==='مستفيد') {
                    $extraquestion = [
                        'number_of_needy' => 'required|integer|min:1|max:20',
                        'current_housing_condition' => 'required|in:ملك,أجار,لا يوجد سكن',
                        'document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                        'host_address' => 'required_if:current_housing_condition,لا يوجد سكن|string|max:255',
                        'host_number' => 'required_if:current_housing_condition,لا يوجد سكن|string|max:15',
                        'description' => 'required|string|max:1000',
                    ];
                }
            elseif ($typeName === 'تعليمية' && $user->role ==='مستفيد') {
                    $extraquestion = [
                        'number_of_needy' => 'required|integer|min:1|max:20',
                        'educational_needs' => 'required|array|min:1',
                        'educational_needs.*' => 'string|max:255',
                        'expected_cost' => 'nullable|numeric|min:0',
                        'description' => 'required|string|max:1000',
                    ];
                    }
            elseif ($typeName === 'غذائية' && $user->role ==='مستفيد') {
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
        }

    }
