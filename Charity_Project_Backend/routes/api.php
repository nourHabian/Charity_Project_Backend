<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);

Route::post('/login', [UserController::class, 'login']);

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::put('/editpassword', [UserController::class, 'editPassword'])->middleware('auth:sanctum');
Route::get('/getUser', [UserController::class, 'GetUserInformation'])->middleware('auth:sanctum');



Route::post('/admin/addProject', [ProjectController::class, 'addProject']);
Route::put('/admin/editProject/{id}', [ProjectController::class, 'editProject']);
Route::get('/getallProject', [ProjectController::class, 'getallProject']);
Route::delete('/admin/deleteProject/{id}', [ProjectController::class, 'deleteProject']);




/*



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