<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Agama;
use App\Models\JenisKawin;
use App\Models\JenisPegawai;
use App\Models\StatusPegawai;
use Illuminate\Http\Request;

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
        Pegawai::create(
            $request->validate(
                [
                    'nik' => 'required|digits:16',
                    'nip' => 'required|digits:18',
                    'nama_depan' => 'required|regex:/^[\pL\s\-]+$/u',
                    'nama_belakang' => 'required|regex:/^[\pL\s\-]+$/u',
                    'jenis_kelamin' => 'required',
                    'agama_id' => 'required',
                    'golongan_darah' => 'required',
                    'jenis_kawin_id' => 'required',
                    'tempat_lahir' => 'required',
                    'tanggal_lahir' => 'required',
                    'email_kantor' => 'required',
                    'email_pribadi' => 'required',
                    'no_telp' => 'required|digits:16',
                    'jenis_pegawai_id' => 'required',
                    'status_pegawai_id' => 'required',
                    'status_dinas' => 'required',
                ],
                [
                    'nik.required' => 'Wajib diisi.',
                    'nik.digits' => 'Terdiri dari :digits digit angka.',
                    'nip.required' => 'Wajib diisi.',
                    'nip.digits' => 'Terdiri dari :digits digit angka.',
                    'nama_depan.required' => 'Wajib diisi.',
                    'nama_depan.regex' => 'Terdiri dari karakter huruf.',
                    'nama_belakang.required' => 'Wajib diisi.',
                    'nama_belakang.regex' => 'Terdiri dari karakter huruf.',
                    'jenis_kelamin.required' => 'Wajib diisi.',
                ]
            ),
        );

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
