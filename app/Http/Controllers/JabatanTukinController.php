<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class JabatanTukinController extends Controller
{

    public function create()
    {
        try {
            return Inertia::render('JabatanTukin/Create',[
                'title' => 'Tambah Gaji'
            ]);
        }catch (QueryException $e){
            Log::error('terjadi kesalahan pada koneksi database  ketika load create data :' . $e->getMessage());
             return redirect()->back()->withErrors([
                    'query' => 'Load data gagal'
                ]);
        }

    }
}
