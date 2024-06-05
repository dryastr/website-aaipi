<?php

namespace App\Providers;

use App\Models\ParamsWebsite;
use Illuminate\Support\Facades\View;
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
        View::composer('*', function ($view) {
            $icons = ParamsWebsite::where('module', 'MEDIA_SOCIAL')->get();
            $alamat = ParamsWebsite::where('kode', 'KONTAK_ALAMAT_KANTOR')->first();
            $email = ParamsWebsite::where('kode', 'KONTAK_EMAIL_KAMI')->first();
            $contact = ParamsWebsite::where('kode', 'KONTAK_HUBUNGI_KAMI')->first();
            $view->with('web_kontak_alamat', $alamat);
            $view->with('web_kontak_email', $email);
            $view->with('web_kontak_contact', $contact);
            $view->with('icons', $icons);
        });
    }
}
