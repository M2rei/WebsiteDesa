<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{

    protected $table = 'struktur_organisasi';
    protected $fillable = ['desa_id', 'image'];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
