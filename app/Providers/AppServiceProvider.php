<?php

namespace App\Providers;

use App\Models\Desa;
use App\Models\Informasi;
use App\Models\PotensiDesa;
use Illuminate\Support\Facades\Schema;
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
        $sharedData = [];

        if (Schema::hasTable('desa')) {
            $sharedData['desa'] = Desa::first();
        }

        if (Schema::hasTable('informasi')) {
            $sharedData['informasiTerbaru'] = Informasi::latest()->take(3)->get();
        }

        if (Schema::hasTable('potensi_desa')) {
            $sharedData['potensi_desa'] = PotensiDesa::get();
        }

        View::share($sharedData);
    }
}
