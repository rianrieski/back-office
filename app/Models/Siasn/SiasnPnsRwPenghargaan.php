<?php

namespace App\Models\Siasn;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiasnPnsRwPenghargaan extends Model
{
    use HasFactory;

    protected $table = 'siasn_pns_rw_penghargaan';

    protected $guarded = [];

    protected $casts = [
        'path' => 'array'
    ];

    public function siasnPegawai(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SiasnPnsDataUtama::class, 'pnsOrangId', 'id');
    }
}
