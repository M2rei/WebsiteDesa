<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    protected $table = 'informasi';
    protected $primaryKey = 'id';

    protected $fillable = ['judul', 'deskripsi', 'kategori', 'tanggal_publish', 'penulis'];

    public function lampiran()
    {
        return $this->hasOne(Lampiran::class);
    }
}
