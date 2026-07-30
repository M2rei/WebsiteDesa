<?php

namespace App\Providers;

use App\Models\Desa;
use App\Models\Informasi;
use App\Models\PotensiDesa;
use Illuminate\Support\Facades\Cache;
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

        if ($this->tableExists('desa')) {
            $sharedData['desa'] = Desa::first();
        }

        if ($this->tableExists('informasi')) {
            $sharedData['informasiTerbaru'] = Informasi::latest()->take(3)->get();
        }

        if ($this->tableExists('potensi_desa')) {
            $sharedData['potensi_desa'] = PotensiDesa::get();
        }

        View::share($sharedData);
    }

    /**
     * Cache only positive results so a table created after boot() first runs
     * (e.g. before the initial migration) is picked up without a manual cache clear.
     */
    private function tableExists(string $table): bool
    {
        if (Cache::get("schema_has_{$table}")) {
            return true;
        }

        $exists = Schema::hasTable($table);

        if ($exists) {
            Cache::forever("schema_has_{$table}", true);
        }

        return $exists;
    }
}
