<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use App\Banner;
use App\PostCategory;


class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $banners = Banner::where('status', 0)->orderByDesc('id')->get();
        $postCategories = PostCategory::where('status', 0)->orderByDesc('id')->get();

        view()->share(['banners' => $banners, 'postCategories' => $postCategories]);

        Blade::if('hasRole', function ($expression) {
            if (Auth::user()) {
                if (Auth::user()->hasAnyRoles($expression)) {
                    return true;
                }
            }
            return false;
        });
    }
}
