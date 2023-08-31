<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Agama;
use App\Models\JenisKawin;
use App\Models\JenisPegawai;
use App\Models\StatusPegawai;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate(
            [
                'nik' => 'required|digits:16',
                'nip' => 'required|digits:18',
                'nama_depan' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
                'nama_belakang' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
                'jenis_kelamin' => 'required',
                'agama_id' => 'required',
                'golongan_darah' => 'required',
                'jenis_kawin_id' => 'required',
                'tempat_lahir' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
                'tanggal_lahir' => 'required',
                'email_kantor' => 'required|email:rfc,dns',
                'email_pribadi' => 'required|email:rfc,dns',
                // 'no_telp' => 'required|numeric|between:11,13',
                'no_telp' => 'required|numeric',
                'jenis_pegawai_id' => 'required',
                'status_pegawai_id' => 'required',
                'status_dinas' => 'required',
                'no_kartu_pegawai' => 'required',
                // 'no_kartu_pegawai' => 'required|between:7,10',
                'no_bpjs' => 'required|digits:13',
                'no_taspen' => 'max:50',
                'npwp' => 'max:50',
                'no_enroll' => 'max:50',
                'media_kartu_pegawai' => 'nullable|mimes:jpg,png|max:1024',
                'media_foto_pegawai' => 'nullable|mimes:jpg,png|max:1024',
            ],
            [
                'nik.required' => 'Wajib diisi.',
                'nik.digits' => 'Terdiri dari :digits digit angka.',
                'nip.required' => 'Wajib diisi.',
                'nip.digits' => 'Terdiri dari :digits digit angka.',
                'nama_depan.required' => 'Wajib diisi.',
                'nama_depan.max' => 'Maksimal 50 karakter.',
                'nama_depan.regex' => 'Terdiri dari karakter huruf.',
                'nama_belakang.required' => 'Wajib diisi.',
                'nama_belakang.max' => 'Maksimal 50 karakter.',
                'nama_belakang.regex' => 'Terdiri dari karakter huruf.',
                'jenis_kelamin.required' => 'Wajib dipilih.',
                'agama_id.required' => 'Wajib dipilih.',
                'golongan_darah.required' => 'Wajib dipilih.',
                'jenis_kawin_id.required' => 'Wajib dipilih.',
                'tempat_lahir.required' => 'Wajib diisi.',
                'tempat_lahir.max' => 'Maksimal 50 karakter.',
                'tempat_lahir.regex' => 'Terdiri dari karakter huruf.',
                'tanggal_lahir.required' => 'Wajib diisi.',
                'email_kantor.required' => 'Wajib diisi.',
                'email_kantor.email' => 'Email tidak valid.',
                'email_pribadi.required' => 'Wajib diisi.',
                'email_pribadi.email' => 'Email tidak valid.',
                'no_telp.required' => 'Wajib diisi.',
                'no_telp.numeric' => 'Hanya diperbolehkan angka.',
                // 'no_telp.between' => 'Diantara 11-13 digit angka.',
                'jenis_pegawai_id.required' => 'Wajib diisi.',
                'status_pegawai_id.required' => 'Wajib diisi.',
                'status_dinas.required' => 'Wajib diisi.',
                'no_kartu_pegawai.required' => 'Wajib diisi.',
                // 'no_kartu_pegawai.between' => 'Diantara 7-10 karakter.',
                'no_bpjs.required' => 'Wajib diisi.',
                'no_bpjs.digits' => 'Terdiri dari :digits digit angka.',
                'no_taspen.max' => 'Maksimal Terdiri dari :max karakter.',
                'npwp.max' => 'Maksimal Terdiri dari :max karakter.',
                'no_enroll.max' => 'Maksimal Terdiri dari :max karakter.',
                'media_kartu_pegawai.mimes' => 'Hanya mendukung tipe file :mimes.',
                'media_kartu_pegawai.max' => 'Ukuran file maksimal 1 MB.',
                'media_foto_pegawai.mimes' => 'Hanya mendukung tipe file :mimes.',
                'media_foto_pegawai.max' => 'Ukuran file maksimal 1 MB.',
            ]
        );

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

        return inertia(
            'Pegawai/Show',
            [
                'pegawai' => $pegawai,
                'media_foto_pegawai' => $pegawai->getMedia("media_foto_pegawai")[0]->getUrl(),
                'media_kartu_pegawai' => $pegawai->getMedia("media_kartu_pegawai"),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        return inertia(
            'Pegawai/Edit',
            [
                'pegawai' => $pegawai,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
