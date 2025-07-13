<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratDesa extends Model
{
    protected $table = 'surat_desa';
    protected $primaryKey = 'id';
    protected $fillable = ['desa_id', 'dokumen', 'status'];

    public function dataPendukung()
    {
        return $this->hasMany(DataPendukung::class);
    }
}
