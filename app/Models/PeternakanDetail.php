<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeternakanDetail extends Model
{
    use HasFactory;

    protected $table = 'ternak_peternak';

    protected $fillable = [
        'peternak_id',
        'jenis_ternak',
        'jenis_kelamin',
        'jumlah',
        'total_jumlah',
        'riwayat_penyakit',
        'vitamin',
        'keterangan',
    ];

    public function peternak()
    {
        return $this->belongsTo(Peternak::class);
    }
}
