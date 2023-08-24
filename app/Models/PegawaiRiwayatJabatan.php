<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiRiwayatJabatan extends Model
{
    protected $table = 'pegawai_riwayat_jabatan';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
    public function jabatan_unit_kerja()
    {
        return $this->belongsTo(JabatanUnitKerja::class);
    }
    public function media()
    {
        return $this->hasOne(Media::class,'media_sk_id');
    }
}
