<?php

namespace App\Integration\Siap\Model;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $connection = 'db_siap';
    protected $table = 'Pegawai';
    protected $primaryKey = 'PegawaiID';
    public $timestamps = false;
}
