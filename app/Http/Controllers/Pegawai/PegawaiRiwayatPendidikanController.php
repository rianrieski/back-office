<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaiRiwayatPendidikanRequest;
use App\Models\Kota;
use App\Models\Pegawai;
use App\Models\PegawaiRiwayatPendidikan;
use App\Models\Pendidikan;
use App\Models\Propinsi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PegawaiRiwayatPendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Pegawai/PegawaiRiwayatPendidikan/Index',[
            'title'=>'Riwayat Pendidikan'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::getAllDataPegawai();
        $pendidikan = Pendidikan::select('id','nama')->get();
        $propinsi = Propinsi::select('id','nama')->get();
        return Inertia::render('Pegawai/PegawaiRiwayatPendidikan/Create',[
            'title'=>'Tambah Riwayat Pendidikan',
            'pegawai'=>$pegawai,
            'pendidikan'=>$pendidikan,
            'propinsi'=>$propinsi,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PegawaiRiwayatPendidikanRequest $request)
    {
        $riwayatPendidikan = new PegawaiRiwayatPendidikan();
        $riwayatPendidikan->pegawai_id = $request->pegawai_id;
        $riwayatPendidikan->pendidikan_id = $request->pendidikan_id;
        $riwayatPendidikan->nama_instansi = $request->nama_instansi;
        $riwayatPendidikan->propinsi_id = $request->propinsi_id;
        $riwayatPendidikan->kota_id = $request->kota_id;
        $riwayatPendidikan->alamat = $request->alamat;
        $riwayatPendidikan->no_ijazah = $request->no_ijazah;
        $riwayatPendidikan->tanggal_ijazah = $request->tanggal_ijazah;
        $riwayatPendidikan->kode_gelar_depan = $request->kode_gelar_depan;
        $riwayatPendidikan->kode_gelar_belakang = $request->kode_gelar_belakang;
        try {
            DB::transaction(function ()use($riwayatPendidikan){
                $riwayatPendidikan->save();
                $riwayatPendidikan->addMediaFromRequest('media_ijazah')->toMediaCollection('media_ijazah');
            });
            return redirect()->back()->with('success','riwayat pendidikan berhasil disimpan');

        }catch (QueryException $e){
            return redirect()->back()->withErrors(['query'=>'riwayat pendidikan gagal disimpan']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $riwayatPendidikanDetail = PegawaiRiwayatPendidikan::where('pegawai_riwayat_pendidikan.id',$id)
            ->join('pegawai','pegawai.id','=','pegawai_riwayat_pendidikan.pegawai_id')
            ->join('pendidikan','pendidikan.id','=','pegawai_riwayat_pendidikan.pendidikan_id')
            ->join('propinsi','propinsi.id','=','pegawai_riwayat_pendidikan.propinsi_id')
            ->join('kota','kota.id','=','pegawai_riwayat_pendidikan.kota_id')
            ->select('pegawai_riwayat_pendidikan.id',DB::raw("DATE_FORMAT(tanggal_ijazah, '%d %b %Y') AS tanggal_ijazah")
                ,DB::raw('CONCAT(pegawai.nama_depan," " ,pegawai.nama_belakang) AS nama_lengkap')
                ,'pendidikan.nama AS nama_pendidikan'
                ,'nama_instansi','propinsi.nama AS propinsi' ,'kota.nama AS kota','alamat','no_ijazah'
                ,'kode_gelar_depan','kode_gelar_belakang')->first();
        $riwayatPendidikanDetail->media_ijazah = $riwayatPendidikanDetail->getMedia("media_ijazah")[0]->getUrl();
        if($riwayatPendidikanDetail == null){
            return response()->json(['status'=>404,'message'=>'data tidak ditemukan'],404);
        }else{
            return response()->json(['status'=>200,'message'=>'OK','data'=>$riwayatPendidikanDetail],200);
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
        $riwayatPendidikanDetail = PegawaiRiwayatPendidikan::where('id',$id)->first();

        return Inertia::render('Pegawai/PegawaiRiwayatPendidikan/Edit',[
            'title'=>'Edit Riwayat Pendidikan',
            'riwayatPendidikanDetail'=>$riwayatPendidikanDetail,
            'propinsi'=>Propinsi::select('id','nama')->get(),
            'pendidikan'=>Pendidikan::select('id','nama')->get(),
            'pegawai'=>Pegawai::getAllDataPegawai(),
            'kota'=> Kota::where('propinsi_id',$riwayatPendidikanDetail->propinsi_id)->select('id','nama')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PegawaiRiwayatPendidikanRequest $request, string $id)
    {
        try {
            $riwayatPendidikan = PegawaiRiwayatPendidikan::where('id',$id)->first();
            if ($riwayatPendidikan != null){
                $riwayatPendidikan->pegawai_id = $request->pegawai_id;
                $riwayatPendidikan->pendidikan_id = $request->pendidikan_id;
                $riwayatPendidikan->nama_instansi = $request->nama_instansi;
                $riwayatPendidikan->propinsi_id = $request->propinsi_id;
                $riwayatPendidikan->kota_id = $request->kota_id;
                $riwayatPendidikan->alamat = $request->alamat;
                $riwayatPendidikan->no_ijazah = $request->no_ijazah;
                $riwayatPendidikan->tanggal_ijazah = $request->tanggal_ijazah;
                $riwayatPendidikan->kode_gelar_depan = $request->kode_gelar_depan;
                $riwayatPendidikan->kode_gelar_belakang = $request->kode_gelar_belakang;
                DB::transaction(function ()use($riwayatPendidikan, $request){
                    $riwayatPendidikan->save();
                    if ($request->file('media_ijazah')) {
                        $riwayatPendidikan->clearMediaCollection('media_ijazah');
                        $riwayatPendidikan->addMediaFromRequest('media_ijazah')->toMediaCollection('media_ijazah');
                    }
                });
                return redirect()->back()->with('success','riwayat diklat berhasil diubah');
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
        $riwayatPendidikan = PegawaiRiwayatPendidikan::where('id',$id)->first();

        if ($riwayatPendidikan ==null){
            return redirect()->back()->withErrors([
                'query' => 'riwayat pendidikan gagal dihapus atau tidak ditemukan'
            ]);
        }
        try {
            DB::transaction(function ()use($riwayatPendidikan){
                if ($riwayatPendidikan->hasMedia("media_ijazah")) {
                    $riwayatPendidikan->getMedia("media_ijazah")[0]->delete();
                }
                $riwayatPendidikan->delete();
            });
            return redirect()->back()->with('success','riwayat pendidikan berhasil dihapus');
        }catch (QueryException $e){
            return redirect()->withErrors(['queruy'=>'riwayat pendidikan gagal dihapus']);
        }
    }
    public function getDataRiwayatPendidikan(Request $request){
        $paginate = ($request->paginate) ? $request->paginate : 10;
        $riwayatPendidikan = PegawaiRiwayatPendidikan::query()->when($request->cari,function ($query,$cari){
            $query->orWhere(DB::raw("CONCAT(nama_depan,' ',nama_belakang)"),'like',"%{$cari}%");
            $query->orWhere(DB::raw("DATE_FORMAT(tanggal_ijazah, '%d %b %Y')"),'like',"%{$cari}%");
            $query->orWhere('pendidikan.nama','like',"%{$cari}%");
            $query->orWhere('pegawai.nama_depan','like',"%{$cari}%");
            $query->orWhere('pegawai.nama_belakang','like',"%{$cari}%");
            $query->orWhere('nama_instansi','like',"%{$cari}%");
            $query->orWhere('no_ijazah','like',"%{$cari}%");
            $query->orWhere('tanggal_ijazah','like',"%{$cari}%");
        })
            ->join('pegawai','pegawai.id','=','pegawai_riwayat_pendidikan.pegawai_id')
            ->join('pendidikan','pendidikan.id','=','pegawai_riwayat_pendidikan.pendidikan_id')
            ->select('pegawai_riwayat_pendidikan.id',DB::raw('CONCAT(nama_depan," " ,nama_belakang) AS nama_lengkap')
                ,DB::raw("DATE_FORMAT(tanggal_ijazah, '%d %b %Y') AS tanggal_ijazah")
                ,'pendidikan.nama as pendidikan','nama_instansi','no_ijazah')->paginate($paginate);
        return response()->json($riwayatPendidikan);
    }
}
