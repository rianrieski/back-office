<?php

namespace App\Models\Siasn;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiasnPnsDataUtama extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'siasn_pns_data_utama';
    protected $guarded = [];
}
