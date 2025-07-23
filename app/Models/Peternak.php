<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peternak extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'alamat', 'tanggal_mulai', 'tanggal_selesai'];

    public function ternaks()
    {
        return $this->hasMany(PeternakanDetail::class, 'peternak_id');
    }

}
