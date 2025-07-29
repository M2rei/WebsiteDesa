<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peternak extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'alamat', 'periode', 'tahun'];

    public function ternaks()
    {
        return $this->hasMany(PeternakanDetail::class, 'peternak_id');
    }

}
