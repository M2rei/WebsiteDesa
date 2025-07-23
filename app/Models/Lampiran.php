<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{
    protected $table = 'lampiran';

    protected $fillable = ['informasi_id', 'file_path', 'file_type', 'original_name'];

    public function informasi()
    {
        return $this->belongsTo(Informasi::class);
    }
}
