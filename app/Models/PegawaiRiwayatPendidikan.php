<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiRiwayatPendidikan extends Model
{
    protected $table = 'pegawai_riwayat_pendidikan';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class);
    }

    public function media()
    {
        return $this->hasOne(Media::class,'media_ijazah_id');
    }
}
