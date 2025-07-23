<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desa';
    protected $fillable = ['profile_desa', 'sejarah', 'visi', 'misi', 'logo_url', 'nomor_telepon', 'email'];
}
