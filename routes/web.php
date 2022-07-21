<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TribeController;
use App\Http\Controllers\PrayerController;
use App\Http\Controllers\EventController;


use App\Http\Middleware\IsLogin;
use App\Http\Middleware\ForceLogin;

use App\Http\Middleware\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    
    Route::middleware([IsLogin::class])->group(function () { 

        /*********  LoginController Routes **************/
        Route::get('/',[LoginController::class,'index']);
        Route::post('/login-action',[LoginController::class,'login_verify']);

        Route::get('/forget-password',[LoginController::class,'forget_password']);
        Route::post('/forget-password-action',[LoginController::class,'forget_password_submit']);
        
        /** for forget password reset **/
        Route::get('/{id}/reset-password',[LoginController::class,'reset_password']);

        /** for admin reset password **/
        Route::post('/reset-password-action',[LoginController::class,'reset_password_submit']);
        

        
    });


    Route::middleware([ForceLogin::class])->group(function () { 

        /*********  LoginController Routes **************/
        Route::get('logout',[LoginController::class,'logout']);


        /*********  DashboardController Routes **************/
        Route::get('admin/dashboard',[DashboardController::class,'index']);
        Route::get('/error-404',[DashboardController::class,'error']);
        Route::post('admin/change-password-update',[DashboardController::class,'change_pass_update']);

        
        

        Route::get('admin/change-password', function () {
                return view('change_password');
        });
        

        /*********  UserController Routes **************/
        Route::get('admin/user-management',[UserController::class,'index'])->middleware('Permission:Users-Read');
        Route::post('admin/user-edit-store',[UserController::class,'user_update'])->middleware('Permission:Users-Update');
        Route::get('admin/add-user',[UserController::class,'user_add'])->middleware('Permission:Users-Create');
        Route::get('admin/user-delete',[UserController::class,'delete_user'])->middleware('Permission:Users-Delete');
        Route::get('admin/user-status-update',[UserController::class,'update_status'])->middleware('Permission:Users-Update');
        Route::post('admin/user-store',[UserController::class,'store'])->middleware('Permission:Users-Create');
        Route::get('admin/member-management',[UserController::class,'member_list_view'])->middleware('Permission:Users-Read');

        Route::post('admin/select_userinfo',[UserController::class,'fetch_alldata']);
        Route::post('admin/admin-edit-store',[UserController::class,'admin_update'])->middleware('Permission:Users-Update');
        //Route::get('admin/c_code',[UserController::class,'c_code']);


        /*********  RoleController Routes **************/   
        Route::get('admin/roles',[RoleController::class,'index'])->middleware('Permission:Settings-Read');
        Route::get('admin/add-role',[RoleController::class,'create'])->middleware('Permission:Settings-Create');
        Route::post('admin/role-store',[RoleController::class,'store'])->middleware('Permission:Settings-Create');
        Route::get('admin/{id}/edit-role',[RoleController::class,'edit'])->middleware('Permission:Settings-Update');
        Route::post('admin/role-update',[RoleController::class,'update'])->middleware('Permission:Settings-Update');
        
        /*********  TribeController Routes **************/   
        Route::get('admin/tribe-list',[TribeController::class,'index'])->middleware('Permission:Tribe-Read');
        Route::get('admin/add-new-tribe',[TribeController::class,'create'])->middleware('Permission:Tribe-Create');
        Route::post('admin/tribe-store',[TribeController::class,'store'])->middleware('Permission:Tribe-Create');
        Route::get('admin/{id}/edit-tribe',[TribeController::class,'edit'])->middleware('Permission:Tribe-Update');
        Route::post('admin/update-tribe',[TribeController::class,'update'])->middleware('Permission:Tribe-Update');
        Route::get('admin/{id}/delete-tribe',[TribeController::class,'delete'])->middleware('Permission:Tribe-Delete');
        Route::post('admin/tribe-status-update',[TribeController::class,'status_update'])->middleware('Permission:Tribe-Update');
        Route::post('admin/make-tribe-subscribe',[TribeController::class,'subscribe_tribe'])->middleware('Permission:Tribe-Update');
        Route::post('admin/fetch_subscribe_tribe',[TribeController::class,'fetch_subscribe_list'])->middleware('Permission:Tribe-Read');


        /*********  PrayerController Routes **************/  
        Route::get('admin/prayer',[PrayerController::class,'index'])->middleware('Permission:Prayer-Read');
        Route::get('admin/create-new-prayer',[PrayerController::class,'create'])->middleware('Permission:Prayer-Create');
        Route::post('admin/prayer-store',[PrayerController::class,'store'])->middleware('Permission:Prayer-Create');
        Route::get('admin/{id}/edit-prayer',[PrayerController::class,'edit'])->middleware('Permission:Prayer-Update');
        Route::post('admin/prayer-update',[PrayerController::class,'update'])->middleware('Permission:Prayer-Update');

        
       
        /*********  EventController Routes **************/  
        Route::get('admin/events',[EventController::class,'index'])->middleware('Permission:Event-Read');
        Route::get('admin/create-new-event',[EventController::class,'create'])->middleware('Permission:Event-Create');
        Route::post('admin/event-store',[EventController::class,'store'])->middleware('Permission:Event-Create');
        Route::post('admin/event-status-update',[EventController::class,'status_update'])->middleware('Permission:Event-Update');
        Route::get('admin/{id}/edit-event',[EventController::class,'edit'])->middleware('Permission:Event-Update');
        Route::post('admin/update-event',[EventController::class,'update'])->middleware('Permission:Event-Update');
        Route::get('admin/{id}/delete-event',[EventController::class,'delete'])->middleware('Permission:Event-Delete');


        
        

        
    });
   
