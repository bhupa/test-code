<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Your password protected routes.
Route::get('/', function () {
    return view('home');
})->middleware(\Sven\SuperBasicAuth\SuperBasicAuth::class);

Route::get('migrate-refresh', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');

    return 'done migrate and seed';
});
Route::get('migrate', function () {
    Artisan::call('migrate');

    return 'Done migrate';
});
Route::get('storage-link', function () {
    Artisan::call('storage:link');

    return 'link done';
});
Route::get('term-conditions', function () {
    return view('term-conditions');
});
Route::get('privacy-policy', function () {
    return view('privacy-policy');
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
