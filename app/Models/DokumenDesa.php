<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenDesa extends Model
{
    protected $table = 'dokumen_desa';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_document', 'kategori', 'desa_id', 'dokumen','fields'];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
