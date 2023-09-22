<?php

namespace App\Providers;

use Laravel\Scantum\Exceptions\AuthenticationException;
use Illuminate\Support\ServiceProvider;

class ScantumServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton(AuthenticationException::class, function($app,$request,$gaurds){
         return response()->json(['message'=>'Unathenticated'],401);
        });
    }
}
