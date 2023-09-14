<?php

namespace App\Http\Controllers\Siasn;

use App\Http\Controllers\Controller;
use App\Models\Siasn\SiasnPnsDataUtama;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class SiasnPnsController extends Controller
{
    public function index()
    {
        return Inertia::render('Siasn/Asn/Index', [
            'asn' => QueryBuilder::for(SiasnPnsDataUtama::class)
                ->allowedFilters(['nama', 'nipBaru', 'jabatanNama', 'unorNama'])
                ->allowedSorts(['nama', 'nipBaru', 'jabatanNama', 'unorNama'])
                ->paginate(request('per_page', 15))
                ->withQueryString()
//                ->appends(request()->query())
        ]);
    }

    public function show($asn)
    {
        return Inertia::render('Siasn/Asn/Show', [
            'asn' => SiasnPnsDataUtama::find($asn),
        ]);
    }
}
