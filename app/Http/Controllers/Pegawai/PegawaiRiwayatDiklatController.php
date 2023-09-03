<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaiRiwayatDiklatRequest;
use App\Models\JenisDiklat;
use App\Models\Pegawai;
use App\Models\PegawaiRiwayatDiklat;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PegawaiRiwayatDiklatController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Pegawai/PegawaiRiwayatDiklat/Index',[
            'title'=>'Riwayat Diklat'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Pegawai/PegawaiRiwayatDiklat/Create',[
            'title'=>'Tambah Riwayat',
            'pegawai' =>Pegawai::getAllDataPegawai(),
            'jenis_diklat'=>JenisDiklat::select('id','nama')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PegawaiRiwayatDiklatRequest $request)
    {
        $diklat = new PegawaiRiwayatDiklat();
        $diklat->pegawai_id = $request->pegawai_id;
        $diklat->jenis_diklat_id = $request->jenis_diklat_id;
        $diklat->tanggal_mulai = $request->tanggal_mulai;
        $diklat->tanggal_akhir = $request->tanggal_akhir;
        $diklat->jam_pelajaran = $request->jam_pelajaran;
        $diklat->lokasi = $request->lokasi;
        $diklat->penyelenggaran =$request->penyelenggaran;
        $diklat->no_sertifikat = $request->no_sertifikat;
        $diklat->tanggal_sertifikat = $request->tanggal_sertifikat;
        try {
            DB::transaction(function ()use($diklat){
                $diklat->save();
                $diklat->addMediaFromRequest('media_sertifikat')->toMediaCollection('media_sertifikat');
            });
            return redirect()->back()->with('success','riwayat diklat berhasil disimpan');
        }catch (QueryException $e){
            Log::error($e);
            return redirect()->back()->withErrors(['query'=>'riwayat diklat gagal disimpan']);
        }
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
