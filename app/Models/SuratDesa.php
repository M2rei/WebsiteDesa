<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratDesa extends Model
{
    protected $fillable = ['data_pendukung_id', 'dokumen', 'status'];

    public function dataPendukung()
    {
        return $this->belongsTo(DataPendukung::class);
    }
}
