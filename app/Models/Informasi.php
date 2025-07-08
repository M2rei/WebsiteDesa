<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    protected $table = 'informasi';
    protected $primaryKey = 'id';

    protected $fillable = ['desa_id', 'judul', 'image', 'deskripsi','kategori', 'tanggal_publish', 'penulis'];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
