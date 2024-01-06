<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;








//web Routes

Route::post('/user-registration', [UserController::class, 'UserRegistration']) -> name('user-registration');
Route::post('/user-login', [UserController::class, 'UserLogin']) -> name('user-login');
Route::get('/user-profile', [UserController::class, 'UserProfile'])->middleware('auth:sanctum') -> name('user-profile');
Route::get('/logout', [UserController::class, 'UserLogout'])->middleware('auth:sanctum') -> name('logout');
Route::post('/user-update', [UserController::class, 'UserUpdate'])->middleware('auth:sanctum') -> name('user-update');
Route::post('/send-otp', [UserController::class, 'SendOtp'])-> name('send-otp');
Route::post('/verify-otp', [UserController::class, 'VerifyOtp'])-> name('verify-otp');
Route::post('/reset-password', [UserController::class, 'ResetPassword']) ->middleware('auth:sanctum')-> name('reset-password');




//View Routes

Route::view('/','pages.home');
Route::view('/user-login','admin.components.auth.login')->name('login');
Route::view('/user-registration','admin.components.auth.registration')->name('user-registration');
Route::view('/userProfile','admin.components.auth.profile')->name('userProfile');
Route::view('/send-otp','admin.components.auth.sentOtp')->name('send-otp') ;
Route::view('/verify-otp','admin.components.auth.verify-otp')->name('verify-otp');
Route::view('/reset-password','admin.components.auth.reset-pass')->name('reset-password');










































//view
