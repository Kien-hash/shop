<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Banner;

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
        $banners = Banner::where('status',0)->orderByDesc('id')->get();
        view()->share('banners', $banners);

    }
}
