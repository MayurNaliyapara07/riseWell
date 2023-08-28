<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\GeneralSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view)
        {
            $data = Auth::user();
            $generalSetting = GeneralSetting::first();
            $getCountryName = Country::where('code',$generalSetting->country_code)->first();
            $view->with('current_user', $data);
            $view->with('general_setting', $generalSetting);
            $view->with('getCountryName', $getCountryName);
        });
        Schema::defaultStringLength(191);
    }
}
