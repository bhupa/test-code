<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
    'as' => config('admin.route.prefix').'.',
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('companies', CompanyController::class);
    $router->resource('job-categories', JobCategoryController::class);
    $router->resource('jobseekers', JobSeekerController::class);
    $router->resource('users', UsersController::class);
    $router->resource('jobs', JobsController::class);
});
