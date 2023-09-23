<?php

namespace App\Http\Controllers\Siasn;

use App\Enums\ToastIcon;
use App\Http\Controllers\Controller;
use App\Services\SiasnSimpegService;

class FetchAllPnsDataUtamaController extends Controller
{
    public function __invoke()
    {
        (new SiasnSimpegService())->fetchAllPnsDataUtama(sync: false);

        return back()->with('toast', [
            'icon' => ToastIcon::SUCCESS,
            'message' => 'Sinkronisasi data sedang diproses',
        ]);
    }
}
