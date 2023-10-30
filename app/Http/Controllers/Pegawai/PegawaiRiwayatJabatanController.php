<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PegawaiRiwayatJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Pegawai $profil_pegawai)
    {
        $profil_pegawai->with([
            'pegawai_riwayat_jabatan:id,pegawai_id,jabatan_unit_kerja_id' => [
                'jabatan_unit_kerja:id,jabatan_tukin_id,hirarki_unit_kerja_id' =>
                ['jabatan_tukin:id,jabatan_id,jenis_jabatan_id,tukin_id']

            ]
        ]);

        // dd($profil_pegawai->pegawai_riwayat_jabatan()->get());

        return Inertia::render('Pegawai/PegawaiRiwayatJabatan/Index', [
            'pegawai' => fn () => $profil_pegawai,
            'media_foto_pegawai' => fn () => $profil_pegawai->getFirstMediaUrl('media_foto_pegawai'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::select('id', 'nama_depan', 'nama_belakang')->get();

        // $unitKerja = UnitKerja::all();

        // $arrayUnitKerja = array();
        // foreach ($unitKerja as $item) {
        //     array_push($arrayUnitKerja, $item->nama);
        // }

        // dd($arrayUnitKerja);



        return inertia('Pegawai/PegawaiRiwayatJabatan/Create', [
            'pegawai' => $pegawai,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->pegawai_id['id']);
        // dd($request->pegawai_id);
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
