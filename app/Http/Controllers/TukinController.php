<?php

namespace App\Http\Controllers;

use App\Http\Requests\TukinStoreRequest;
use App\Models\Tukin;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TukinController extends Controller
{
    public function index()
    {
        return Inertia::render('Tukin/Index', [
            'tukin_list' => Tukin::all(),
        ]);
    }

    public function store(TukinStoreRequest $request)
    {
        $data = $request->validated();

        Tukin::create($data);

        return back()->with('toast', ['message' => 'Data berhasil disimpan']);
    }

    public function update(TukinStoreRequest $request, Tukin $tukin)
    {
        $data = $request->validated();

        $tukin->update($data);

        return back()->with('toast', ['message' => 'Data berhasil disimpan']);
    }

    public function destroy(Tukin $tukin)
    {
        $tukin->delete();

        return back()->with('toast', ['message' => 'Data berhasil dihapus']);
    }
}
