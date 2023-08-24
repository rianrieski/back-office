<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public function pegawai_riwayat_jabatan()
    {
        return $this->belongsTo(PegawaiRiwayatJabatan::class,'media_sk_id');
    }
    public function pegawai_riwayat_diklat()
    {
        return $this->belongsTo(PegawaiRiwayatDiklat::class,'media_sertifikat_id');
    }
    public function pegawai_riwayat_pendidikan()
    {
        return $this->belongsTo(PegawaiRiwayatPendidikan::class,'media_ijazah_id');
    }
    public function pegawai_suami_istri_foto_pasangan()
    {
        return $this->belongsTo(PegawaiSuamiIstri::class,'media_foto_pasangan_id');
    }
    public function pegawai_suami_istri_buku_nikah()
    {
        return $this->belongsTo(PegawaiSuamiIstri::class,'media_buku_nikah_id');
    }
}
