<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiRiwayatDiklat extends Model
{
    protected $table = 'pegawai_riwayat_diklat';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
    public function jenis_diklat()
    {
        return $this->belongsTo(JenisDiklat::class);
    }
    public function media()
    {
        return $this->hasOne(Media::class,'media_sertifikat_id');
    }
}
