<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\HariLibur;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use PhpParser\Node\Expr\Cast\Object_;

class HariLiburController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('HariLibur/Index',[
            'title'=>'Hari Libur'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('HariLibur/Create',[
            'title'=>'Tambah Hari Libur'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'=>['required','date_format:Y-m-d'],
            'keterangan'=>['required','max:100'],
            'is_libur'=>['required','boolean'],
        ],[
            'tanggal.required'=>'tanggal libur harus diisi',
            'tanggal.date_format'=>'tanggal harus dalam bentuk format yang valid',
            'keterangan.required'=>'keterangan harus diisi',
            'keterangan.max'=>'keterangan maksimal 100 karakter',
            'is_libur.required'=>'status libur harus diisi',
            'is_libur.boolean' => 'status libur tidak valid',

        ]);
        $hariLibur = new HariLibur();
        $hariLibur->tahun = date("Y",strtotime($request->tanggal));
        $hariLibur->tanggal = $request->tanggal;
        $hariLibur->keterangan = trim(ucwords($request->keterangan));
        $hariLibur->is_libur = $request->is_libur;
        try{
            $hariLibur->save();
            return redirect()->back()->with('success','hari libur berhasil disimpan');
        }catch (QueryException $e){
            return redirect()->back()->withErrors(['query'=>'hari libur gagal disimpan']);
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
        $hariLiburDetail = HariLibur::select('id','tanggal','is_libur','keterangan')->where('id',$id)->first();
        if ($hariLiburDetail == null){
            return redirect()->withErrors(['query','hari libur tidak ditemukan']);
        }
        return Inertia::render('HariLibur/Edit',[
            'title'=>'Edit Hari Libur',
            'hariLiburDetail'=>$hariLiburDetail
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal'=>['required','date_format:Y-m-d'],
            'keterangan'=>['required','max:100'],
            'is_libur'=>['required','boolean'],
        ],[
            'tanggal.required'=>'tanggal libur harus diisi',
            'tanggal.date_format'=>'tanggal harus dalam bentuk format yang valid',
            'keterangan.required'=>'keterangan harus diisi',
            'keterangan.max'=>'keterangan maksimal 100 karakter',
            'is_libur.required'=>'status libur harus diisi',
            'is_libur.boolean' => 'status libur tidak valid',

        ]);
        $hariLibur = HariLibur::where('id',$id)->first();
        $hariLibur->tahun = date("Y",strtotime($request->tanggal));
        $hariLibur->tanggal = $request->tanggal;
        $hariLibur->keterangan = trim(ucwords($request->keterangan));
        $hariLibur->is_libur = $request->is_libur;
        try{
            $hariLibur->save();
            return redirect()->back()->with('success','hari libur berhasil diubah');
        }catch (QueryException $e){
            return redirect()->back()->withErrors(['query'=>'hari libur gagal diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $hariLibur = HariLibur::where('id',$id)->first();
        if ($hariLibur == null){
            return redirect()->back()->withErrors([
                'query' => 'data hari libur gagal dihapus'
            ]);
        }
        try {
            $hariLibur->delete();
            return redirect()->back()->with('success','data hari libur berhasil dihapus');
        }catch (QueryException $e){
            Log::error('terjadi kesalahan pada koneksi database');
            return redirect()->back()->withErrors([
                'query' => 'data hari libur pegawai gagal dihapus'
            ]);
        }
    }

    public function getDataHariLibur(Request $request)
    {
        $paginate = ($request->paginate) ? $request->paginate : 10;
        $hariLibur = HariLibur::query()->when($request->cari,function ($query,$cari){
            $query->orWhere('tahun','like',"%{$cari}%");
            $query->orWhere(DB::raw("DATE_FORMAT(tanggal, '%d %b %Y')"),'like',"%{$cari}%");
            $query->orWhere('keterangan','like',"%{$cari}%");
            $query->orWhere(DB::raw('CASE WHEN is_libur = 1 THEN "Libur" WHEN is_libur = 0 THEN "Tidak Libur" END'), 'like', "{$cari}%");
        })
            ->select('id','tahun','keterangan','is_libur',DB::raw("DATE_FORMAT(tanggal, '%d %b %Y') AS tanggal"))
            ->addSelect(DB::raw('CASE WHEN is_libur = 1 THEN "Libur" WHEN is_libur = 0 THEN "Tidak Libur" END AS status_libur'))
            ->orderBy('tahun','DESC')
            ->paginate($paginate);
        return response()->json($hariLibur);

    }
}
