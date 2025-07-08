<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenDesa extends Model
{
    protected $fillable = ['nama_document', 'kategori', 'desa_id', 'dokumen'];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
