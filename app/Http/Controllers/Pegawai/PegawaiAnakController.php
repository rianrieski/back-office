<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaiAnakRequest;
use App\Models\Pegawai;
use App\Models\PegawaiAnak;
use App\Models\Pendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class PegawaiAnakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Pegawai/PegawaiAnak/Index',[
            'title'=>'Anak Pegawai'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Pegawai/PegawaiAnak/Create',[
            'title'=>'Tambah Anak',
            'pegawai'=>Pegawai::getAllDataPegawai(),
            'pendidikan'=>Pendidikan::select('id','nama')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PegawaiAnakRequest $request)
    {
        $pegawaiAnak = new PegawaiAnak();
        $pegawaiAnak->pegawai_id = $request->pegawai_id;
        $pegawaiAnak->nama = $request->nama;
        $pegawaiAnak->nik = $request->nik;
        $pegawaiAnak->anak_ke = $request->anak_ke;
        $pegawaiAnak->tempat_lahir = $request->tempat_lahir;
        $pegawaiAnak->tanggal_lahir = $request->tanggal_lahir;
        $pegawaiAnak->status_anak = $request->status_anak;
        $pegawaiAnak->status_tunjangan = $request->status_tunjangan;
        $pegawaiAnak->pendidikan_id = $request->pendidikan_id;
        $pegawaiAnak->bidang_studi = $request->bidang_studi;
        try {
            $pegawaiAnak->save();
            return redirect()->back()->with('success','anak pegawai berhasil disimpan');
        }catch (QueryException $e){
            Log::error($e);
            return redirect()->back()->withErrors(['query'=>'anak pegawai gagal disimpan']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pegawaiAnak = PegawaiAnak::where('pegawai_anak.id',$id)
            ->join('pegawai','pegawai.id','=','pegawai_anak.pegawai_id')
            ->join('pendidikan','pendidikan.id','=','pegawai_anak.pendidikan_id')
            ->select('pegawai_anak.id'
                ,DB::raw('CONCAT(pegawai.nama_depan," " ,pegawai.nama_belakang) AS nama_lengkap')
                ,'pendidikan.nama AS nama_pendidikan'
                ,'pegawai_anak.nama AS nama','anak_ke','pegawai_anak.nik AS nik'
                ,'pegawai_anak.tempat_lahir','status_anak','bidang_studi'
            , DB::raw("DATE_FORMAT(pegawai_anak.tanggal_lahir, '%d %b %Y') AS tanggal_lahir"))
            ->addSelect(DB::raw('CASE WHEN pegawai_anak.status_tunjangan = 1 THEN "Aktif"
            WHEN pegawai_anak.status_tunjangan = 0 THEN "Tidak Aktif" END AS status_tunjangan'))
            ->first();
        if($pegawaiAnak == null){
            return response()->json(['status'=>404,'message'=>'data tidak ditemukan'],404);
        }else{
            return response()->json(['status'=>200,'message'=>'OK','data'=>$pegawaiAnak],200);
        }
        try {

        }catch (QueryException $e){
            return response()->json(['status'=>500,'message'=>'kesalahan pada server'],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pegawaiAnakDetail = PegawaiAnak::where('id',$id)->first();
        return Inertia::render('Pegawai/PegawaiAnak/Edit',[
            'title'=>'Edit Anak',
            'pegawai'=>Pegawai::getAllDataPegawai(),
            'pendidikan'=>Pendidikan::select('id','nama')->get(),
            'pegawaiAnakDetail'=>$pegawaiAnakDetail
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PegawaiAnakRequest $request, string $id)
    {
        $pegawaiAnak = PegawaiAnak::where('id',$id)->first();
        $pegawaiAnak->pegawai_id = $request->pegawai_id;
        $pegawaiAnak->nama = $request->nama;
        $pegawaiAnak->nik = $request->nik;
        $pegawaiAnak->anak_ke = $request->anak_ke;
        $pegawaiAnak->tempat_lahir = $request->tempat_lahir;
        $pegawaiAnak->tanggal_lahir = $request->tanggal_lahir;
        $pegawaiAnak->status_anak = $request->status_anak;
        $pegawaiAnak->status_tunjangan = $request->status_tunjangan;
        $pegawaiAnak->pendidikan_id = $request->pendidikan_id;
        $pegawaiAnak->bidang_studi = $request->bidang_studi;
        try {
            $pegawaiAnak->save();
            return redirect()->back()->with('success','anak pegawai berhasil diedit');
        }catch (QueryException $e){
            Log::error($e);
            return redirect()->back()->withErrors(['query'=>'anak pegawai gagal diedit']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pegawaiAnak = PegawaiAnak::where('id',$id)->first();
        if ($pegawaiAnak ==null){
            return redirect()->back()->withErrors([
                'query' => 'data anak gagal dihapus'
            ]);
        }
        try {
            $pegawaiAnak->delete();
            return redirect()->back()->with('success','data anak pegawai berhasil dihapus');
        }catch (QueryException $e){
            Log::error('terjadi kesalahan pada koneksi database');
            return redirect()->back()->withErrors([
                'query' => 'data anak pegawai gagal dihapus'
            ]);
        }
    }
    public function getDataPegawaiAnak(Request $request)
    {
        $paginate = ($request->paginate) ? $request->paginate : 10;
        $pegawaiAnak = PegawaiAnak::query()->when($request->cari,function ($query,$cari){
            $query->orWhere(DB::raw("CONCAT(nama_depan,' ',nama_belakang)"),'like',"%{$cari}%");
            $query->orWhere('nama','like',"%{$cari}%");
            $query->orWhere('pegawai.nik','like',"%{$cari}%");
            $query->orWhere('status_tunjangan','like',"%{$cari}%");
            $query->orWhere(DB::raw('CASE WHEN pegawai_anak.status_tunjangan = 1 THEN "Aktif" WHEN pegawai_anak.status_tunjangan = 0 THEN "Tidak Aktif" END'),'like',"{$cari}%");
        })
            ->join('pegawai','pegawai.id','=','pegawai_anak.pegawai_id')
            ->select('pegawai_anak.id',DB::raw('CONCAT(nama_depan," " ,nama_belakang) AS nama_lengkap')
                ,'nama','pegawai.nik')
            ->addSelect(DB::raw('CASE WHEN pegawai_anak.status_tunjangan = 1 THEN "Aktif" WHEN pegawai_anak.status_tunjangan = 0 THEN "Tidak Aktif" END AS status_tunjangan'))
            ->paginate($paginate);
        return response()->json($pegawaiAnak);
    }
}
