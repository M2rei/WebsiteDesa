<?php

namespace App\Providers;

use App\Models\Berita;
use App\Models\Desa;
use App\Models\Informasi;
use App\Models\PotensiDesa;
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
        $desa = Desa::first();
        $informasi = Informasi::get();
        $potensi_desa = PotensiDesa::get();
        View::share([
            'desa' => $desa,
            'informasi' => $informasi,
            'potensi_desa' => $potensi_desa,
        ]);
    }
}
