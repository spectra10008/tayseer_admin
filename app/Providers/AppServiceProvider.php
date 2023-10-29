<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Notification;
use App\Models\MfiNotification;
use View;
use Auth;

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
        View::composer('*', function ($view) {
            $new_notifications = Notification::where('is_read',1)->get();
            if (Auth::guard('mfis_providers')->check()) {
                $mfi_notifications = MfiNotification::where('is_read',1)->where('mfi_provider_id',Auth::guard('mfis_providers')->user()->mfi_provider_id)->get();
            }else
            {
                $mfi_notifications = [];
            }

            $view
                ->with('new_notifications', $new_notifications)
                ->with('mfi_notifications', $mfi_notifications)
            ;
        });
    }
}
