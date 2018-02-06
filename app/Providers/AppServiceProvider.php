<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator;

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
//        Validator::resolver(function($translator, $data, $rules, $messages){
//            return new MyValidator($translator, $data, $rules, $messages);
//        });
        $this->app['validator']->resolver(function($translator, $data, $rules, $messages){
            return new \App\Extensions\MyValidator($translator, $data, $rules, $messages);
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
