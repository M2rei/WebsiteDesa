<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ternak extends Model
{
    use HasFactory;

    protected $fillable = ['jenis_ternak', 'bangsa'];

    public function peternaks()
    {
        return $this->belongsToMany(Peternak::class, 'ternak_peternak')
            ->withPivot(['jenis_kelamin', 'jumlah', 'jenis_pakan', 'penyakit', 'sistem_pemeliharaan'])
            ->withTimestamps();
    }
}
