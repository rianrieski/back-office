<?php

namespace App\Services;

use App\Integration\Presensi\Model\Pegawai;

class PresensiService
{
    public static function getAllNip(): \Illuminate\Support\Collection
    {
        return Pegawai::select('nipp as nip')
            ->whereNotNull('nipp')
            ->get()
            ->pluck('nip');
    }
}
