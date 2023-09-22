<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\Api\V1\Auth\UserController;
// use App\Http\Controllers\Api\V1\Auth\EmailVerificationController;
// use App\Http\Controllers\Api\V1\Auth\EmailForgotPassword;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// verison 1 api
// login register
Route::group(['prefix' => 'v1', 'namespace' => 'V1\Auth'], function () {
    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@register');

    Route::post('check-phone', 'UserController@checkPhone');

    // reset password
    Route::post('forgot-password', 'EmailForgotPassword@forgot');
    Route::post('reset-password', 'EmailForgotPassword@reset');
    Route::get('verify-otp', 'EmailForgotPassword@verifyOtp');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', 'UserController@logout');
        Route::post('change-status', 'UserController@changeStatus');
        Route::get('user-details/{id}', 'UserController@getUserDetails');
        Route::post('device-token', 'UserController@addingDeviceToke');
    });
});
Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function () {
    //   Route::get('/locations','LocationController@index');
    //   Route::get('working-hour','WorkingBreakTimeController@getWorkingHour');
    //   Route::get('break-time','WorkingBreakTimeController@getBreakTime');
    Route::post('web-hook', 'SubscriptionController@webhook');
    Route::post('/social-login', 'SocialLoginController@login');
    Route::get('category', 'CategoryController@index');
    Route::get('profile', 'ProfileController@index');
});
Route::group(['prefix' => 'v1', 'namespace' => 'V1', 'middleware' => 'auth:sanctum'], function () {
    Route::post('email/verification-notification', 'Auth\EmailVerificationController@sendVerificationEmail');
    // Route::get('verify-email/{id}/{hash}', 'Auth\EmailVerificationController@verify');

    Route::get('/company', 'CompanyController@index');
    Route::get('company/{company}', 'CompanyController@show');
    Route::get('company-details', 'CompanyController@getCompanyDetails')->middleware('company_owner');

    Route::get('/job', 'JobController@index');
    Route::get('/job/matches', 'JobController@match')->middleware('jobseeker');
    Route::get('job/{jobs}', 'JobController@show');

    Route::get('jobseeker-details', 'JobSeekerController@getJobSeekerDetails');
    Route::get('/jobseeker/{jobseeker}', 'JobSeekerController@show');
    Route::get('/jobseeker', 'JobSeekerController@index');

    Route::group(['prefix' => 'company'], function () {
        Route::post('store', 'CompanyController@store')->middleware('company_owner');
        Route::post('/{company}', 'CompanyController@update')->middleware('company_owner');
        Route::delete('/{company}', 'CompanyController@destroy')->middleware('company_owner');

        Route::get('/{company}', 'CompanyController@show')->middleware('company_owner');
    });

    Route::group(['prefix' => 'image-file'], function () {
        Route::get('/{imagefiles}', 'ImageFileController@show');
        Route::delete('/{imagefiles}', 'ImageFileController@destroy');
    });

    Route::group(['prefix' => 'jobseeker'], function () {
        Route::post('store', 'JobSeekerController@store');
        Route::post('/{jobseeker}', 'JobSeekerController@update');
        Route::delete('/{jobseeker}', 'JobSeekerController@destroy');
    });

    Route::group(['prefix' => 'job'], function () {
        Route::post('/store', 'JobController@store')->middleware('company_owner');
        Route::post('/{jobs}', 'JobController@update')->middleware('company_owner');
        Route::delete('/{jobs}', 'JobController@destroy')->middleware('company_owner');
    });

    Route::group(['prefix' => 'matching'], function () {
        Route::get('/', 'MatchingController@index');
        Route::post('/request', 'MatchingController@store');
        Route::post('/accept/{matching}', 'MatchingController@accept');
        Route::post('favourite', 'MatchingController@favourite');
        Route::post('/{matching}', 'MatchingController@update');
        Route::delete('/{matching}', 'MatchingController@destroy');
    });
    Route::post('stripe-payment', 'StripeController@paymentProcess');
    Route::post('add-plan', 'SubscriptionController@addPlan');
});

// verify email
// Route::group(['prefix' => 'v1'],function(){
//     Route::post('email/verification-notification', 'EmailVerificationController@sendVerificationEmail')->middleware('auth:sanctum');
//     Route::get('verify-email/{id}/{hash}', 'EmailVerificationController@verify')->middleware('auth:sanctum');
// });
