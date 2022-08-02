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
    Route::post('/get_video_comment',[AppController::class, 'get_video_comment'])->middleware('VerifyBrrToken');
    Route::post('/video_comment_edit',[AppController::class, 'video_comment_edit'])->middleware('VerifyBrrToken');
    Route::post('/video_comment_delete',[AppController::class, 'video_comment_delete'])->middleware('VerifyBrrToken');
    Route::post('/get_notification',[AppController::class, 'get_notification'])->middleware('VerifyBrrToken');
    Route::post('/notification_seen', [AppController::class, 'notification_seen'])->middleware('VerifyBrrToken');
    Route::post('/notification_delete', [AppController::class, 'notification_delete'])->middleware('VerifyBrrToken');
    Route::post('/get_all_details', [AppController::class, 'get_all_details'])->middleware('VerifyBrrToken');

    //TRIBE
    Route::post('/add_new_tribe', [AppController::class, 'add_new_tribe'])->middleware('VerifyBrrToken');
    Route::post('/add_tribe', [AppController::class, 'add_tribe'])->middleware('VerifyBrrToken');
    Route::post('/get_all_tribe', [AppController::class, 'get_all_tribe'])->middleware('VerifyBrrToken');
    Route::post('/get_details_user_tribe',[AppController::class,'get_details_user_tribe'])->middleware('VerifyBrrToken');
    Route::post('/user_in_tribe_group',[AppController::class,'user_in_tribe_group'])->middleware('VerifyBrrToken');
    Route::post('/user_not_in_tribe_group',[AppController::class,'user_not_in_tribe_group'])->middleware('VerifyBrrToken');
    Route::post('/delete_user_from_group',[AppController::class, 'delete_user_from_group'])->middleware('VerifyBrrToken');
    Route::post('/update_admin_from_group',[AppController::class,'update_admin_from_group'])->middleware('VerifyBrrToken');
    Route::post('/update_tribe_details',[AppController::class,'update_tribe_details'])->middleware('VerifyBrrToken');
    Route::post('/tribe_status',[AppController::class,'tribe_status'])->middleware('VerifyBrrToken');
    Route::post('/inactive_to_active_status',[AppController::class,'inactive_to_active_status'])->middleware('VerifyBrrToken');
    Route::post('/delete_tribe',[AppController::class,'delete_tribe'])->middleware('VerifyBrrToken');
    Route::post('/update_tribe_name',[AppController::class,'update_tribe_name'])->middleware('VerifyBrrToken');
    Route::post('/tribe_change_image',[AppController::class,'tribe_change_image'])->middleware('VerifyBrrToken');
    Route::post('/request_pending_tribe_group',[AppController::class,'request_pending_tribe_group'])->middleware('VerifyBrrToken');
    Route::post('/request_approve_tribe_group',[AppController::class,'request_approve_tribe_group'])->middleware('VerifyBrrToken');
    Route::post('/get_user_details_using_mobile_no',[AppController::class,'get_user_details_using_mobile_no'])->middleware('VerifyBrrToken');
    Route::post('/add_user_tribe_group',[AppController::class,'add_user_tribe_group'])->middleware('VerifyBrrToken');
    Route::post('/tribe_chat',[AppController::class,'tribe_chat'])->middleware('VerifyBrrToken');



    /********  Api/UserController Route ********/
    Route::post('/user_details', [UserController::class, 'index'])->middleware('VerifyBrrToken');
    Route::post('/valid_user', [UserController::class, 'valid_user']);
    Route::post('/user_approval', [UserController::class, 'user_approval'])->middleware('VerifyBrrToken');
    Route::post('/get_details_using_phon_no', [UserController::class, 'get_details_using_phon_no'])->middleware('VerifyBrrToken');
