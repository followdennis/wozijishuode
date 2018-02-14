<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Vinkla\Hashids\Facades\Hashids;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        \Validator::extend('hashid', function ($attribute, $value, $parameters, $validator) {
            try
            {
                $key_value = Hashids::decode($value)[0];
            }catch (\Exception $exception)
            {
                return false;
            }
            return true;
        });
        \Validator::replacer('hashid', function ($message, $attribute, $rule, $parameters) {
            return str_replace($message,$attribute, 'The '.$message.' is wrong hash value!');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
