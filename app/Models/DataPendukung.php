<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPendukung extends Model
{
    protected $fillable = ['image'];

    public function suratDesa()
    {
        return $this->hasMany(SuratDesa::class);
    }
}
