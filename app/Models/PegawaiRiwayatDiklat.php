<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class PegawaiRiwayatDiklat extends Model
{
    use InteractsWithMedia;

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
}
