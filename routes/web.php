<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
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

Route::view('/dashboard','admin.components.dashboard.summary')->name('dashboard');
Route::view('/user-login','admin.components.auth.login')->name('login');
Route::view('/user-registration','admin.components.auth.registration')->name('user-registration');
Route::view('/userProfile','admin.components.auth.profile')->name('userProfile');
Route::view('/send-otp','admin.components.auth.sentOtp')->name('send-otp') ;
Route::view('/verify-otp','admin.components.auth.verify-otp')->name('verify-otp');
Route::view('/reset-password','admin.components.auth.reset-pass')->name('reset-password');




//Category Web Routes

Route::post('/create-category', [CategoryController::class, 'CreateCategory']) -> name('create-category')->middleware('auth:sanctum');
Route::post('/update-category', [CategoryController::class, 'UpdateCategory']) -> name('update-category')->middleware('auth:sanctum');
Route::post('/delete-category', [CategoryController::class, 'DeleteCategory']) -> name('delete-category')->middleware('auth:sanctum');
Route::get('/list-category', [CategoryController::class, 'ListCategory']) -> name('list-category')->middleware('auth:sanctum');
Route::post('/category-by-id', [CategoryController::class, 'CategoryById']) -> name('category-by-id')->middleware('auth:sanctum');





//Customer web Routes
Route::post('/customer-create', [CustomerController::class, 'CustomerCreate']) -> name('customer-create')->middleware('auth:sanctum');
Route::post('/customer-update', [CustomerController::class, 'CustomerUpdate']) -> name('customer-update')->middleware('auth:sanctum');
Route::get('/list-customer', [CustomerController::class, 'CustomerList']) -> name('list-customer')->middleware('auth:sanctum');
Route::post('/customer-by-id', [CustomerController::class, 'CustomerById']) -> name('customer-by-id')->middleware('auth:sanctum');
Route::post('/customer-delete', [CustomerController::class, 'CustomerDelete']) -> name('customer-delete')->middleware('auth:sanctum');



//Product Web Routes
Route::post('/product-create', [ProductController::class, 'ProductCreate']) -> name('product-create')->middleware('auth:sanctum');
Route::post('/product-update', [ProductController::class, 'ProductUpdate']) -> name('product-update')->middleware('auth:sanctum');
Route::get('/list-product', [ProductController::class, 'ProductList']) -> name('list-product')->middleware('auth:sanctum');
Route::post('/product-by-id', [ProductController::class, 'ProductById']) -> name('product-by-id')->middleware('auth:sanctum');
Route::post('/product-delete', [ProductController::class, 'ProductDelete']) -> name('product-delete')->middleware('auth:sanctum');




//Invoice Web Routes
Route::post('/invoice-create', [InvoiceController::class, 'InvoiceCreate'])->name('')->middleware('auth:sanctum');
Route::get('/list-invoice', [InvoiceController::class, 'InvoiceList'])->name('')->middleware('auth:sanctum');
Route::post('/invoice-details', [InvoiceController::class, 'InvoiceById'])->name('')->middleware('auth:sanctum');
Route::post('/invoice-delete', [InvoiceController::class, 'InvoiceDelete'])->name('')->middleware('auth:sanctum');


//Category View Routes

Route::get('/dashboard-summary', [DashboardController::class, 'Dashboard'])->middleware('auth:sanctum');

Route::view('/category-list','admin.pages.dashboard.category')->name('category-list');
Route::view('/customer-list','admin.pages.dashboard.customer')->name('customer-list');
Route::view('/product-list','admin.pages.dashboard.product')->name('product-list');











































//view
