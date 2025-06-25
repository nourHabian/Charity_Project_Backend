<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\FavouriteController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [UserController::class, 'register']);
Route::post('/verifyEmail', [UserController::class, 'verify_email']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');;
Route::put('/editpassword', [UserController::class, 'editPassword'])->middleware('auth:sanctum');;
Route::get('/getUser', [UserController::class, 'GetUserInformation'])->middleware('auth:sanctum');

Route::post('/favourite', [FavouriteController::class, 'addToFavourite'])->middleware('auth:sanctum');
Route::delete('/favourite', [FavouriteController::class, 'removeFromFavourite'])->middleware('auth:sanctum');
Route::get('/favourite', [FavouriteController::class, 'getFavouriteProjects'])->middleware('auth:sanctum');
Route::get('/favourite/search', [FavouriteController::class, 'searchFavourite'])->middleware('auth:sanctum');

Route::get('/getVolunteerProjectsByType/{volunteeringDomain}', [ProjectController::class, 'getVolunteerProjectsByType']);


Route::post('/donor/volunteerRequest', [VolunteerController::class, 'addVolunteerRequest'])->middleware('auth:sanctum');

Route::post('/donor/addToBalance', [UserController::class, 'addToBalance'])->middleware('auth:sanctum');
Route::post('/donor/giveGift', [UserController::class, 'giveGift'])->middleware('auth:sanctum');
Route::post('/donor/giveZakat', [UserController::class, 'giveZakat'])->middleware('auth:sanctum');
Route::post('/donor/donateToProject/{id}', [UserController::class, 'donateToProject'])->middleware('auth:sanctum');

Route::post('/notifications', [NotificationController::class, 'showAllAndMarkAsRead'])->middleware('auth:sanctum');
Route::get('/donations/user', [DonationController::class, 'getUserDonations'])->middleware('auth:sanctum');

Route::get('/donor/home', [ProjectController::class, 'home'])->middleware('auth:sanctum');
Route::get('/donor/projects/health', [ProjectController::class, 'healthProjects'])->middleware('auth:sanctum');
Route::get('/donor/projects/educational', [ProjectController::class, 'educationalProjects'])->middleware('auth:sanctum');
Route::get('/donor/projects/residential', [ProjectController::class, 'residentialProjects'])->middleware('auth:sanctum');
Route::get('/donor/projects/nutritional', [ProjectController::class, 'nutritionalProjects'])->middleware('auth:sanctum');
Route::get('/donor/projects/emergency', [ProjectController::class, 'emergencyProjects'])->middleware('auth:sanctum');

Route::post('/donor/monthlyDonation', [UserController::class, 'monthlyDonation'])->middleware('auth:sanctum');
Route::put('/donor/cancelMonthlyDonation', [UserController::class, 'cancelMonthlyDonation'])->middleware('auth:sanctum');


Route::post('/admin/doAllMonthlyDonations', [AdminController::class, 'monthlyDonations']);


Route::get('/admin/getAllVolunteerRequests', [VolunteerController::class, 'getAllVolunteerRequests']);
Route::post('/admin/addProject', [ProjectController::class, 'addProject']);
// Route::put('/admin/editProject/{id}', [ProjectController::class, 'editProject']);
Route::delete('/admin/deleteProject/{id}', [ProjectController::class, 'deleteProject']);
/*

Route::post('/favourite/{projectId}', [FavouriteController::class, 'addToFavourite'])->middleware('auth:sanctum');
Route::delete('/favourite/{projectId}', [FavouriteController::class, 'removeFromFavourite'])->middleware('auth:sanctum');
Route::get('/favourite', [FavouriteController::class, 'getFavouriteProjects'])->middleware('auth:sanctum');
Route::get('/favourite/search', [FavouriteController::class, 'searchFavourite'])->middleware('auth:sanctum');

Route::get('/donor/randomProjects', [ProjectController::class, 'getRandom'])->middleware('auth:sanctum');
CRUD for projects
Route::get('/admin/addProject', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/getAllProjects', [ProjectController::class, 'get'])->middleware('auth:sanctum');
Route::get('/admin/updateProject', [ProjectController::class, 'update'])->middleware('auth:sanctum');
Route::get('/admin/addProject', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/admin/getProjectByID', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/admin/getProjectByType', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/donateToProject', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/donateToZakat', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/gift', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/addMoney', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/getNotificationsHistory', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/getBalance', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/getDonationHistory', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/getFav', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/getPoints', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/getBestDonors', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/searchProject', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/addVolounteer', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/getVolounteers', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/getVolounteerByID', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/getVolounteerByStatus', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/getFeedbacks', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/autoDonation', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/addDonationRequest', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/updateDonationRequest', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/addFeedback', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/getAllBeneficiary', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/getBeneficiaryByID', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/getBeneficiaryByStatus', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/addOrRemoveDonationRequest', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/addOrRemoveVolounteerRequest', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/updateProjectStatus', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/acceptFeedbacks', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/banVolounteer', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');
Route::get('/donor/banBeneficiary', [ProjectController::class, 'addProject'])->middleware('auth:sanctum');


*/