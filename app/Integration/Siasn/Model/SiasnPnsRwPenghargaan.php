<?php

namespace App\Integration\Siasn\Model;

use Illuminate\Database\Eloquent\Model;

class SiasnPnsRwPenghargaan extends Model
{
    protected $table = 'siasn_pns_rw_penghargaan';

    protected $guarded = [];

    protected $casts = [
        'path' => 'array'
    ];
}
