<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desa';
    protected $fillable = ['profile_desa', 'sejarah', 'visi', 'misi', 'logo_url', 'nomor_telepon', 'email'];

    public function strukturOrganisasis()
    {
        return $this->hasMany(StrukturOrganisasi::class);
    }

    public function potensiDesas()
    {
        return $this->hasMany(PotensiDesa::class);
    }

    public function informasis()
    {
        return $this->hasMany(Informasi::class);
    }

    public function dokumenDesas()
    {
        return $this->hasMany(DokumenDesa::class);
    }
}
