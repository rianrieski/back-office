<?php

namespace App\Http\Controllers;

use App\Http\Requests\TukinStoreRequest;
use App\Models\Tukin;
use Inertia\Inertia;

class TukinController extends Controller
{
    public function index()
    {
        return Inertia::render('Tukin/Index', [
            'title' => 'Tunjangan Kinerja',
            'tukin_list' => fn() => Tukin::all(),
        ]);
    }

    public function store(TukinStoreRequest $request)
    {
        Tukin::create($request->validated());

        return to_route('tukin.index')->with('toast', [
            'message' => 'Data tunjangan kinerja berhasil disimpan'
        ]);
    }

    public function update(TukinStoreRequest $request, Tukin $tukin)
    {
        $tukin->update($request->validated());

        return back()->with('toast', [
            'message' => 'Data tunjangan kinerja berhasil diubah'
        ]);
    }

    public function destroy(Tukin $tukin)
    {
        $tukin->delete();

        return back()->with('toast', [
            'message' => 'Data tunjangan kinerja berhasil dihapus'
        ]);
    }
}
