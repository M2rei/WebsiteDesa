<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PotensiDesa extends Model
{
    protected $table = 'potensi_desa';
    protected $primaryKey = 'id';

    protected $fillable = ['desa_id', 'kategori', 'nama_potensi', 'deskripsi', 'image'];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
