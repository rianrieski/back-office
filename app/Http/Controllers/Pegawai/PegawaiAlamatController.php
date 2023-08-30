<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\PegawaiAlamat;
use App\Models\Propinsi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class PegawaiAlamatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Pegawai/PegawaiAlamat/Index',[
            'title' => 'Alamat'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $propinsi = Propinsi::select('id','nama')->get();
        return Inertia::render('Pegawai/PegawaiAlamat/Create',[
            'title'=>'Alamat',
            'propinsi' => fn()=>$propinsi,
            'kota' =>Inertia::lazy(fn()=>Kota::select('id','propinsi_id','nama')
                ->where('propinsi_id',$request->propinsi_id)
                ->get()),
            'kecamatan' =>Inertia::lazy(fn()=>Kecamatan::select('id','kota_id','nama')
                ->where('kota_id',$request->kota_id)
                ->get()),
            'desa' =>Inertia::lazy(fn()=>Desa::select('id','kecamatan_id','nama')
                ->where('kecamatan_id',$request->kecamatan_id)
                ->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipe_alamat' =>['required',Rule::in(["D","K"])],
            'propinsi_id' =>['required','max:10'],
            'kota_id' =>['required','max:20'],
            'kecamatan_id' =>['required','max:20'],
            'desa_id' =>['required','max:20'],
            'kode_pos' =>['required','max:5'],
            'alamat' =>['required'],
        ],[
            'tipe_alamat.required'=>'tipe alamat harus diisi',
            'tipe_alamat.in'=>'tipe alamat tidak valid',
            'propinsi_id.required'=>'propinsi harus diisi',
            'propinsi_id.max'=>'propinsi tidak valid',
            'kota_id.required'=>'kota/kabupaten harus diisi',
            'kota_id.max'=>'kota/kabupaten tidak valid',
            'kecamatan_id.required'=>'kecamatan harus diisi',
            'kecamatan_id.max'=>'kecamatan tidak valid',
            'desa_id.required'=>'desa harus diisi',
            'desa_id.max'=>'desa tidak valid',
            'kode_pos.required'=>'kode pos harus diisi',
            'kode_pos.max'=>'kode pos tidak valid',
            'alamat.required'=>'alamat harus diisi',
        ]);
        $alamat = new PegawaiAlamat();
        $alamat->pegawai_id = 1;
        $alamat->tipe_alamat = $request->tipe_alamat;
        $alamat->propinsi_id = $request->propinsi_id;
        $alamat->kota_id = $request->kota_id;
        $alamat->kecamatan_id = $request->kecamatan_id;
        $alamat->desa_id = $request->desa_id;
        $alamat->kode_pos = $request->kode_pos;
        $alamat->alamat = $request->alamat;
        try {
            $alamat->save();
            return redirect()->back()->with('success','Data alamat berhasil disimpan');
        }catch (QueryException $e){
            Log::error('terjadi kesalahan pada koneksi database');
             return redirect()->back()->withErrors([
            'query' => 'data alamat gagal disimpan'
        ]);
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

    /**
     * GET DATA KOTA BY PROPINSI ID.
     */
    public function getKota(Request $request)
    {
        $kota = Kota::select('id','propinsi_id','nama')
            ->where('propinsi_id',$request->propinsi_id)
            ->get();
        return response()->json($kota);
    }
}
