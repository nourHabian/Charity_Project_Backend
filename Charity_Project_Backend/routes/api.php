<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





// ******************************** DONOR APIS ********************************

// donor account creation
Route::post('/register', [UserController::class, 'register']);
Route::post('/verifyEmail', [UserController::class, 'verify_email']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    // logout
    Route::post('/logout', [UserController::class, 'logout']);
    // edit donor's password
    Route::put('/editpassword', [UserController::class, 'editPassword']);
    // get donor's information
    Route::get('/getUser', [UserController::class, 'GetUserInformation']);

   
    // ****** DONATE LATER LIST ******

    // add a project to donate later list
    Route::post('/favourite', [FavouriteController::class, 'addToFavourite']);
    // remove a project from donate later list
    Route::delete('/favourite', [FavouriteController::class, 'removeFromFavourite']);
    // get all projects in donate later list
    Route::get('/favourite', [FavouriteController::class, 'getFavouriteProjects']);
    // search in donate later list
    Route::get('/favourite/search', [FavouriteController::class, 'searchFavourite']);


    // ****** VOLUNTEER ACTIONS ******

    // submit a volunteer form
    Route::post('/donor/volunteerRequest', [VolunteerController::class, 'addVolunteerRequest']);
    // volunteer in a project
    Route::post('/volunteer/volunteerInProject/{id}', [UserController::class, 'volunteerInProject']);


    // ****** FINANCIAL TRANSACTIONS ******

    // add to balance
    Route::post('/donor/addToBalance', [UserController::class, 'addToBalance']);
    // give a gift
    Route::post('/donor/giveGift', [UserController::class, 'giveGift']);
    // give zakat
    Route::post('/donor/giveZakat', [UserController::class, 'giveZakat']);
    // donate to a project
    Route::post('/donor/donateToProject/{id}', [UserController::class, 'donateToProject']);
    // activate monthly donation
    Route::post('/donor/monthlyDonation', [UserController::class, 'monthlyDonation']);
    // deactivate monthly donation
    Route::put('/donor/cancelMonthlyDonation', [UserController::class, 'cancelMonthlyDonation']);

  
    // ****** PROJECTS VIEWING ******

    // view permanent projects
    Route::get('/donor/home', [ProjectController::class, 'home']);
    // view health projects
    Route::get('/donor/projects/health', [ProjectController::class, 'healthProjects']);
    // view educational projects
    Route::get('/donor/projects/educational', [ProjectController::class, 'educationalProjects']);
    // view residential projects
    Route::get('/donor/projects/residential', [ProjectController::class, 'residentialProjects']);
    // view nutritional projects
    Route::get('/donor/projects/nutritional', [ProjectController::class, 'nutritionalProjects']);
    // view emergency projects
    Route::get('/donor/projects/emergency', [ProjectController::class, 'emergencyProjects']);
    // view volunteer projects filtered by domain
    Route::get('/getVolunteerProjectsByType/{volunteeringDomain}', [ProjectController::class, 'getVolunteerProjectsByType']);


    // ***** VIEWING APP INFORMATION AND PERSONAL HISTORY *****

    // view feedbacks
    Route::get('/getAcceptedFeedbacks', [FeedbackController::class, 'getAcceptedFeedbacks']);
    // view top ten donors
    Route::get('/getTopDonors', [UserController::class, 'getDonorsByPoints']);
    // view notification history
    Route::post('/notifications', [NotificationController::class, 'showAllAndMarkAsRead']);
    // view donation history
    Route::get('/donations/user', [DonationController::class, 'getUserDonations']);
    

}); 




// ******************************** ADMIN APIS ********************************


// admin account login - logout
Route::post('/admin/login', [AdminController::class, 'loginAdmin']);

Route::middleware('isAdmin')->group(function () {

    Route::post('/admin/doAllMonthlyDonations', [AdminController::class, 'monthlyDonations']);
    Route::get('/admin/getAllVolunteerRequests', [VolunteerController::class, 'getAllVolunteerRequests']);
    // Route::post('/admin/addProject', [ProjectController::class, 'addProject']);
    // Route::put('/admin/editProject/{id}', [ProjectController::class, 'editProject']);
    Route::delete('/admin/deleteProject/{id}', [ProjectController::class, 'deleteProject']);
});



/*
**** TO DO LIST:
******************** أدمن ***********************
**** قسم حلا:
- تسجيل خروج أدمن
- عرض إحصائيات: (عدد المتطوعين الحالي بالجمعية _بس المقبولين_، عدد المحتاجين، عدد المتبرعين، عدد المشاريع، مبلغ التبرعات الكلية)
- عرض كل المشاريع مع فلترة حسب نوعها
- عرض كل طلبات التطوع (مع فلترة مقبول، مرفوض، قيد الدراسة)
- عرض كل المتطوعين (مع فلترة محظور، مو محظور)
- عرض كل طلبات المحتاجين (اول شي فلترة حسب صحي تعليمي سكني غذائي وبعدها فلترة مقبول مرفوض قيد الدراسة)
- عرض كل المحتاجين مع فلترة (محظور - مو محظور)
- عرض الهدايا الواصلة للمحتاجين (مع فلترة تم التسليم ولم يتم التسليم)
- عرض الفيدباكات مع فلترة (مرفوض مقبول قيد الدراسة)
- عرض طلب احتياج كامل مع كل معلوماتو




**** قسم نور:
- حذف مشروع
- اضافة مشروع (جمعية، تطوع، تبرع)
- التبرع لاحد المشاريع (تبرع الان)
- قبول طلب تطوع
- رفض طلب تطوع
- حظر متطوع بشرط يكون مقبول قبل
- قبول محتاج
- رفض محتاج
- حظر محتاج
- زر تم التسليم تبع الهدية
- قبول فيدباك
- رفض فيدباك
- حظر محتاج بسبب فيدباك
- رفرش الادمن (خالصة)


******************** محتاج ***********************
**** قسم بتول:
- انشاء حساب محتاج
- تسجيل دخول 
- تسجيل خروج
- تقديم طلب المساعدة
- ارسال فيدباك بعد ما يكون بعت الطلب
- يشوف سجل اشعارات
- تتبع حالة المشاريع

******************** اشعارات المحتاج ***********************

الاشعارات يلي بتوصلو
- وقت يستلم هدية
- وقت يبعت طلب مساعدة ويكون قيد الدراسة - ينقبل - ينرفض
- وقت ينزل المشروع بالتطبيق
- وقت يتم تسليم الهدية الو
- وقت يكتمل المشروع
- وقت 





*/