<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPendukung extends Model
{
    protected $table = 'data_pendukung';
    protected $primaryKey = 'id';
    protected $fillable = ['surat_desa_id','image'];

    public function suratDesa()
    {
        return $this->belongsTo(SuratDesa::class);
    }
}
