<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratDesa extends Model
{
    protected $table = 'surat_desa';
    protected $primaryKey = 'id';
    protected $fillable = ['jenis_surat','nama', 'nik', 'tempat_tgl_lahir', 'jenis_kelamin', 'agama', 'pekerjaan','no_telepon', 'alamat', 'catatan_pemohon', 'status'];

    public function dataPendukung()
    {
        return $this->hasMany(DataPendukung::class);
    }
}
