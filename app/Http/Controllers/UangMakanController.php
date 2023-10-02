<?php

namespace App\Http\Controllers;

use App\Http\Requests\UangMakanRequest;
use App\Models\Golongan;
use App\Models\UangMakan;
use Inertia\Inertia;

class UangMakanController extends Controller
{
    public function index()
    {
        return Inertia::render('Umak/Index', [
            'title' => 'Uang Makan',
            'umak_list' => fn() => UangMakan::with('golongan:id,nama')->get(),
            'golongan' => fn() => Golongan::select('id', 'nama')->get(),
        ]);
    }

    public function store(UangMakanRequest $request)
    {
        UangMakan::create($request->validated());

        return back()->with('toast', [
            'message' => 'Data uang makan berhasil disimpan'
        ]);
    }

    public function update(UangMakanRequest $request, UangMakan $umak)
    {
        $umak->update($request->validated());

        return back()->with('toast', [
            'message' => 'Data uang makan berhasil diubah'
        ]);
    }

    public function destroy(UangMakan $umak)
    {
        $umak->delete();

        return back()->with('toast', [
            'message' => 'Data uang makan berhasil dihapus'
        ]);
    }
}
