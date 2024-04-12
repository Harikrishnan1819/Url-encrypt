<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

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
        $this->app->resolving(UrlGenerator::class, function (UrlGenerator $generator) {
            $generator->getRoute($name, $parameters = [], $absolute = true);
            // dd($generator);
            // dd(345678);
            // $route = request()->route();
            // // dd($route);
            // dd($route);
            // $params = array_map(function ($value) { 
            //     return encrypt($value);
            // }, $route->parameters);
            // $generator->route($route->uri, $params, true);
        });
    }
}
