<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaStruktur extends Model
{
    protected $table = 'anggota_struktur';
    protected $primaryKey = 'id';

    protected $fillable = ['nama', 'jabatan', 'foto'];
}
