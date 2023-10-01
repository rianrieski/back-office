<?php

namespace App\Services;

use App\Models\Pendidikan;
use Spatie\QueryBuilder\QueryBuilder;

class PendidikanService
{
    public static function getNamaBySearch()
    {
        return QueryBuilder::for(Pendidikan::class)
            ->select('id', 'nama')
            ->allowedFilters(['nama'])
            ->limit(10)
            ->get();
    }
}
