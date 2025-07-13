<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peternak extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'alamat'];

    public function ternaks()
    {
        return $this->belongsToMany(Ternak::class, 'ternak_peternak')
            ->withPivot(['jenis_kelamin', 'jumlah', 'jenis_pakan', 'penyakit', 'sistem_pemeliharaan'])
            ->withTimestamps();
    }
}
