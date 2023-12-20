<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
		
		Validator::extend('page_name', function ($attribute, $value, $parameters, $validator) {
            // Implement your custom validation logic here.
            // You can check if the page name is unique, or any other custom rule.
            return true; // Replace this with your validation logic.
        });
    }
}
