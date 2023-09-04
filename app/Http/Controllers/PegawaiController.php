<?php

namespace App\Http\Controllers;

use App\Http\Requests\PegawaiRequest;
use App\Models\Pegawai;
use App\Models\Agama;
use App\Models\JenisKawin;
use App\Models\JenisPegawai;
use App\Models\StatusPegawai;
use Illuminate\Support\Arr;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = Pegawai::orderBy('id', 'desc')->get();

        return inertia('Pegawai/Index', [
            'pegawai' => $pegawai,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agama = Agama::all();
        $statusNikah = JenisKawin::all();
        $jenisPegawai = JenisPegawai::all();
        $statusPegawai = StatusPegawai::all();

        return inertia('Pegawai/Create', [
            'agama' => $agama,
            'statusNikah' => $statusNikah,
            'jenisPegawai' => $jenisPegawai,
            'statusPegawai' => $statusPegawai,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PegawaiRequest $request)
    {
        // dd($request->all());

        $validated = $request->validated();

        Arr::pull($validated, 'media_kartu_pegawai');
        Arr::pull($validated, 'media_foto_pegawai');

        $pegawai = Pegawai::create($validated);

        $pegawai->addMediaFromRequest('media_foto_pegawai')->toMediaCollection('media_foto_pegawai');
        $pegawai->addMediaFromRequest('media_kartu_pegawai')->toMediaCollection('media_kartu_pegawai');

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pegawai = Pegawai::with([
            'agama:id,nama',
            'jenis_kawin:id,nama',
            'jenis_pegawai:id,nama',
            'status_pegawai:id,nama',
        ])->where('id', $id)->first();

        $fotoPegawai = $pegawai->getMedia("media_foto_pegawai");

        if (count($fotoPegawai) == 0) {
            $urlFotoPegawai = url(asset('assets/noPhotoFound.png'));
        } else {
            $urlFotoPegawai = $fotoPegawai[0]->getUrl();
        }

        $kartuPegawai = $pegawai->getMedia("media_kartu_pegawai");

        if (count($kartuPegawai) == 0) {
            $urlKartuPegawai = url(asset('assets/noPhotoFound.png'));
        } else {
            $urlKartuPegawai = $kartuPegawai[0]->getUrl();
        }

        return inertia(
            'Pegawai/Show',
            [
                'pegawai' => $pegawai,
                'media_foto_pegawai' => $urlFotoPegawai,
                'media_kartu_pegawai' => $urlKartuPegawai,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        $agama = Agama::all();
        $statusNikah = JenisKawin::all();
        $jenisPegawai = JenisPegawai::all();
        $statusPegawai = StatusPegawai::all();

        $fotoPegawai = $pegawai->getMedia("media_foto_pegawai");

        if (count($fotoPegawai) == 0) {
            $urlFotoPegawai = url(asset('assets/noPhotoFound.png'));
        } else {
            $urlFotoPegawai = $fotoPegawai[0]->getUrl();
        }

        $kartuPegawai = $pegawai->getMedia("media_kartu_pegawai");

        if (count($kartuPegawai) == 0) {
            $urlKartuPegawai = url(asset('assets/noPhotoFound.png'));
        } else {
            $urlKartuPegawai = $kartuPegawai[0]->getUrl();
        }

        return inertia(
            'Pegawai/Edit',
            [
                'pegawai' => $pegawai,
                'agama' => fn () => $agama,
                'statusNikah' => fn () => $statusNikah,
                'jenisPegawai' => fn () => $jenisPegawai,
                'statusPegawai' => fn () => $statusPegawai,
                'media_foto_pegawai' => $urlFotoPegawai,
                'media_kartu_pegawai' => $urlKartuPegawai,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PegawaiRequest $request, Pegawai $pegawai)
    {
        $validated = $request->validated();

        Arr::pull($validated, 'media_kartu_pegawai');
        Arr::pull($validated, 'media_foto_pegawai');

        $pegawai->update($validated);

        if ($request->validated('media_foto_pegawai')) {
            $pegawai->clearMediaCollection('media_foto_pegawai');
            $pegawai->addMediaFromRequest('media_foto_pegawai')->toMediaCollection('media_foto_pegawai');
        }

        if ($request->validated('media_kartu_pegawai')) {
            $pegawai->clearMediaCollection('media_kartu_pegawai');
            $pegawai->addMediaFromRequest('media_kartu_pegawai')->toMediaCollection('media_kartu_pegawai');
        }

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        if ($pegawai->hasMedia("media_foto_pegawai")) {
            $pegawai->getMedia("media_foto_pegawai")[0]->delete();
        }

        if ($pegawai->hasMedia("media_kartu_pegawai")) {
            $pegawai->getMedia("media_kartu_pegawai")[0]->delete();
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus!');
    }
}
