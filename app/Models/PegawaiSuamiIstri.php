<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiSuamiIstri extends Model
{
    protected $table = 'pegawai_suami_istri';
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
    public function media_foto_pasangan()
    {
        return $this->hasOne(Media::class,'media_foto_pasangan_id');
    }
    public function media_buku_nikah()
    {
        return $this->hasOne(Media::class,'media_buku_nikah_id');
    }
}
