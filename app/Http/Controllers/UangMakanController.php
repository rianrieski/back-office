<?php

namespace App\Http\Controllers;

use App\Models\UangMakan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UangMakanController extends Controller
{
    public function index()
    {
        return Inertia::render('Umak/Index', [
           'uang_makan' => UangMakan::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'golongan_id' => ['required', 'numeric'],
            'nominal' => ['required', 'numeric']
        ]);

        UangMakan::create($data);

        return back()->with('toast', ['message' => 'Data berhasil disimpan']);
    }

    public function update(Request $request, UangMakan $umak)
    {
        $data = $request->validate([
            'golongan_id' => ['required', 'numeric'],
            'nominal' => ['required', 'numeric']
        ]);

        $umak->update($data);

        return back()->with('toast', ['message' => 'Data berhasil disimpan']);
    }

    public function destroy(UangMakan $umak)
    {
        $umak->delete();

        return back()->with('toast', ['message' => 'Data berhasil dihapus']);
    }
}
