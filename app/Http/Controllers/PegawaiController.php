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
        $pegawai = Pegawai::all();

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
    public function update(PegawaiRequest $request, $id)
    {
        $validated = $request->validated();

        $validatedFotoPegawai = $validated['media_foto_pegawai'];
        $validatedKartuPegawai = $validated['media_kartu_pegawai'];

        Pegawai::where('id', $id)->update([
            'nik' => $validated['nik'],
            'nip' => $validated['nip'],
            'nama_depan' => $validated['nama_depan'],
            'nama_belakang' => $validated['nama_belakang'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'agama_id' => $validated['agama_id'],
            'golongan_darah' => $validated['golongan_darah'],
            'jenis_kawin_id' => $validated['jenis_kawin_id'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'email_kantor' => $validated['email_kantor'],
            'email_pribadi' => $validated['email_pribadi'],
            'no_telp' => $validated['no_telp'],
            'jenis_pegawai_id' => $validated['jenis_pegawai_id'],
            'status_pegawai_id' => $validated['status_pegawai_id'],
            'status_dinas' => $validated['status_dinas'],
            'no_kartu_pegawai' => $validated['no_kartu_pegawai'],
            'tanggal_wafat' => $validated['tanggal_wafat'],
            'tanggal_berhenti' => $validated['tanggal_berhenti'],
            'no_bpjs' => $validated['no_bpjs'],
            'no_taspen' => $validated['no_taspen'],
            'npwp' => $validated['npwp'],
            'no_enroll' => $validated['no_enroll'],
        ]);

        $pegawai = Pegawai::where('id', $id)->first();

        $fotoPegawai = $pegawai->getMedia("media_foto_pegawai");

        if (!empty($validatedFotoPegawai)) {
            if (count($fotoPegawai) != 0) {
                $fotoPegawai[0]->delete();
                $pegawai->addMediaFromRequest('media_foto_pegawai')->toMediaCollection('media_foto_pegawai');
            } elseif (count($fotoPegawai) == 0) {
                $pegawai->addMediaFromRequest('media_foto_pegawai')->toMediaCollection('media_foto_pegawai');
            }
        }

        $kartuPegawai = $pegawai->getMedia("media_kartu_pegawai");

        if (!empty($validatedKartuPegawai)) {
            if (count($kartuPegawai) != 0) {
                $kartuPegawai[0]->delete();
                $pegawai->addMediaFromRequest('media_kartu_pegawai')->toMediaCollection('media_kartu_pegawai');
            } elseif (count($kartuPegawai) == 0) {
                $pegawai->addMediaFromRequest('media_kartu_pegawai')->toMediaCollection('media_kartu_pegawai');
            }
        }

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
