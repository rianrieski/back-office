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
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PegawaiRiwayatDiklatController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Pegawai/PegawaiRiwayatDiklat/Index',[
            'title'=>'Riwayat Diklat',
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
        try {
            $riwayatDiklat = PegawaiRiwayatDiklat::where('pegawai_riwayat_diklat.id',$id)
                ->join('pegawai','pegawai.id','=','pegawai_riwayat_diklat.pegawai_id')
                ->join('jenis_diklat','jenis_diklat.id','=','pegawai_riwayat_diklat.jenis_diklat_id')
                ->select('pegawai_riwayat_diklat.id','tanggal_mulai','tanggal_akhir','lokasi','jam_pelajaran','penyelenggaran','tanggal_sertifikat','no_sertifikat',DB::raw('CONCAT(pegawai.nama_depan," " ,pegawai.nama_belakang) AS nama_lengkap'),'jenis_diklat.nama AS nama_diklat')
                ->first();
            $riwayatDiklat->media_sertifikat = $riwayatDiklat->getMedia("media_sertifikat")[0]->getUrl();
            if($riwayatDiklat == null){
                return response()->json(['status'=>404,'message'=>'data tidak ditemukan'],404);
            }else{
                return response()->json(['status'=>200,'message'=>'OK','data'=>$riwayatDiklat],200);
            }
        }catch (QueryException $e){
            return response()->json(['status'=>500,'message'=>'kesalahan pada server'],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pegawaiRiwayatDiklatDetail = PegawaiRiwayatDiklat::where('id',$id)->first();
        return Inertia::render('Pegawai/PegawaiRiwayatDiklat/Edit',[
            'title'=>'Edit Riwayat',
            'pegawai' =>Pegawai::getAllDataPegawai(),
            'jenis_diklat'=>JenisDiklat::select('id','nama')->get(),
            'pegawaiRiwayatDiklatDetail' => $pegawaiRiwayatDiklatDetail
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PegawaiRiwayatDiklatRequest $request, string $id)
    {
        try {
            $diklat = PegawaiRiwayatDiklat::where('id',$id)->first();
            if ($diklat != null){
                $diklat->pegawai_id = $request->pegawai_id;
                $diklat->jenis_diklat_id = $request->jenis_diklat_id;
                $diklat->tanggal_mulai = $request->tanggal_mulai;
                $diklat->tanggal_akhir = $request->tanggal_akhir;
                $diklat->lokasi = $request->lokasi;
                $diklat->jam_pelajaran = $request->jam_pelajaran;
                $diklat->no_sertifikat = $request->no_sertifikat;
                $diklat->tanggal_sertifikat = $request->tanggal_sertifikat;
                $diklat->penyelenggaran = $request->penyelenggaran;
                DB::transaction(function ()use($diklat, $request){
                    $diklat->save();
                    if ($request->file('media_sertifikat')) {
                        $diklat->clearMediaCollection('media_sertifikat');
                        $diklat->addMediaFromRequest('media_sertifikat')->toMediaCollection('media_sertifikat');
                    }
                });
                return redirect()->back()->with('success','riwayat diklat berhasil diubah');
            }else{
                return redirect()->back()->withErrors(['query'=>'riwayat diklat gagal diubah']);
            }
        }catch (QueryException $e){
            return redirect()->back()->withErrors(['query'=>'riwayat diklat gagal diubah']);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $diklat = PegawaiRiwayatDiklat::where('id',$id)->first();

        if ($diklat ==null){
            return redirect()->back()->withErrors([
                'query' => 'riwayat diklat gagal dihapus atau tidak ditemukan'
            ]);
        }
        try {
            DB::transaction(function ()use($diklat){
                if ($diklat->hasMedia("media_sertifikat")) {
                    $diklat->getMedia("media_sertifikat")[0]->delete();
                }
                $diklat->delete();
            });
        return redirect()->back()->with('success','riwayat diklat berhasil dihapus');
        }catch (QueryException $e){
            return redirect()->withErrors(['queruy'=>'riwayat diklat gagal dihapus']);
        }
    }
    public function getDataRiwayatDiklat(Request $request)
    {
        $paginate = ($request->paginate) ? $request->paginate : 10;
        $riwayatDiklat = PegawaiRiwayatDiklat::query()->when($request->cari,function ($query,$cari){
            $query->orWhereHas('pegawai', function($q) use ($cari) {
                $q->where('nama_depan', 'like', "%{$cari}%");
            });
            $query->orWhereHas('jenis_diklat', function($q) use ($cari) {
                $q->where('nama', 'like', "%{$cari}%");
            });
            $query->orWhere('tanggal_mulai','like',"%{$cari}%");
            $query->orWhere('tanggal_akhir','like',"%{$cari}%");
            $query->orWhere('jam_pelajaran','like',"%{$cari}%");
        })
            ->with('pegawai:id,nama_depan,nama_belakang','jenis_diklat:id,nama')
            ->select('id','pegawai_id','jenis_diklat_id','tanggal_mulai','tanggal_akhir','penyelenggaran','no_sertifikat')->paginate($paginate);
        return response()->json($riwayatDiklat);
    }
}
