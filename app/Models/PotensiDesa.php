<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PotensiDesa extends Model
{
    protected $table = 'potensi_desa';
    protected $primaryKey = 'id';

    protected $fillable = ['kategori', 'nama_potensi', 'deskripsi', 'image'];

}
