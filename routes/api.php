<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\RegistrationController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\AppController;
use App\Http\Middleware\VerifyBrrToken;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

    /********  Registration Controller Route ********/
    Route::post('/register',[RegistrationController::class,'registration_store']);
    Route::post('/register_otp_verify',[RegistrationController::class,'registration_otp_verify']);
    
    /********  AuthController Route ********/
    Route::post('/member_login', [AuthController::class,'member_login']);
    Route::post('/login_otp_verify', [AuthController::class,'otp_verify']);
    Route::post('/other_details', [AuthController::class,'other_details']);

    Route::post('/resend_otp', [AuthController::class,'resend_otp']);
    Route::post('/resend_otp_login', [AuthController::class,'resend_otp_login']);

    /********  Api/AppController Route ********/
    Route::post('/get_country_flag', [AppController::class, 'country_flag']);
    Route::post('/contact_us', [AppController::class, 'contact_us']);
    Route::post('/events', [AppController::class, 'event'])->middleware('VerifyBrrToken');

    Route::post('/tribe', [AppController::class, 'tribe'])->middleware('VerifyBrrToken');
    Route::post('/tribe_privacy',[AppController::class, 'tribe_privacy'])->middleware('VerifyBrrToken');

    Route::post('/video_list',[AppController::class, 'video_list'])->middleware('VerifyBrrToken');
    Route::post('/video_description',[AppController::class, 'video_description'])->middleware('VerifyBrrToken');
    Route::post('/video_comment_post',[AppController::class, 'video_comment_post'])->middleware('VerifyBrrToken');
    Route::post('/video_comment_edit',[AppController::class, 'video_comment_edit'])->middleware('VerifyBrrToken');
    Route::post('/video_comment_delete',[AppController::class, 'video_comment_delete'])->middleware('VerifyBrrToken');

    /********  Api/UserController Route ********/
    Route::post('/user_details', [UserController::class, 'index'])->middleware('VerifyBrrToken');
    Route::post('/valid_user', [UserController::class, 'valid_user']);