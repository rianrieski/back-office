<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\PegawaiTmtGaji;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PegawaiTmtGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Pegawai/PegawaiTmtGaji/Index',[
            'title'=>'Pegawai Tmt Gaji'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::getAllDataPegawai();
        $gaji = Gaji::join('golongan','golongan.id','=','gaji.golongan_id')
            ->select('gaji.id',DB::raw('CONCAT(golongan.nama," | Rp. ", FORMAT(gaji.nominal, 0)) AS nominal_gaji'))
            ->get();
        return Inertia::render('Pegawai/PegawaiTmtGaji/Create',[
            'title'=>'Tambah Tmt Gaji',
            'pegawai'=>$pegawai,
            'gaji'=>$gaji
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id'=>['required','exists:pegawai,id'],
            'gaji_id'=>['required','exists:gaji,id'],
            'tmt_gaji'=>['required']
        ],[
            'pegawai_id'=>'pegawai harus diisi',
            'gaji_id'=>'gaji harus diisi',
            'tmt_gaji'=>'tmt gaji harus diisi',
        ]);
        $tmtGaji = new PegawaiTmtGaji();
        $tmtGaji->pegawai_id = $request->pegawai_id;
        $tmtGaji->gaji_id = $request->gaji_id;
        $tmtGaji->tmt_gaji = $request->tmt_gaji;
        try {
            $tmtGaji->save();
            return redirect()->back()->with('success','tmt gaji berhasil disimpan');
        }catch (QueryException $e){
            Log::error($e);
            return redirect()->back()->withErrors(['query'=>'tmt gaji gagal disimpan']);
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
            $tmtGajiPegawai = PegawaiTmtGaji::where('id',$id)->select('id','pegawai_id','gaji_id','tmt_gaji')->first();
            $pegawai = Pegawai::getAllDataPegawai();
            $gaji = Gaji::join('golongan','golongan.id','=','gaji.golongan_id')
                ->select('gaji.id',DB::raw('CONCAT(golongan.nama," | Rp. ", FORMAT(gaji.nominal, 0)) AS nominal_gaji'))
                ->get();
            return Inertia::render('Pegawai/PegawaiTmtGaji/Edit',[
                'title'=>'Edit Tmt Pegawai',
                'pegawai'=>$pegawai,
                'gaji'=>$gaji,
                'tmtGajiPegawai'=>$tmtGajiPegawai
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'pegawai_id'=>['required','exists:pegawai,id'],
            'gaji_id'=>['required','exists:gaji,id'],
            'tmt_gaji'=>['required']
        ],[
            'pegawai_id'=>'pegawai harus diisi',
            'gaji_id'=>'gaji harus diisi',
            'tmt_gaji'=>'tmt gaji harus diisi',
        ]);
        try {
            $tmtGajiPegawai = PegawaiTmtGaji::where('id',$id)->first();
            $tmtGajiPegawai->pegawai_id = $request->pegawai_id;
            $tmtGajiPegawai->gaji_id = $request->gaji_id;
            $tmtGajiPegawai->tmt_gaji = $request->tmt_gaji;
            $tmtGajiPegawai->save();
            return redirect()->back()->with('success','tmt gaji pegawai berhasil diubah');
        }catch (QueryException $e){
            return redirect()->back()->withErrors(['query'=>'tmt gaji pegawai gaga disimpan']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tmtGajiPegawai = PegawaiTmtGaji::where('id',$id)->first();
        if ($tmtGajiPegawai ==null){
            return redirect()->back()->withErrors([
                'query' => 'data alamat gagal dihapus'
            ]);
        }
        try {
            $tmtGajiPegawai->delete();
            return redirect()->back()->with('success','data tmt gaji pegawai berhasil dihapus');
        }catch (QueryException $e){
            Log::error('terjadi kesalahan pada koneksi database');
            return redirect()->back()->withErrors([
                'query' => 'data tmt gaji pegawai gagal dihapus'
            ]);
        }
    }
    public function getDataTmtGaji(Request $request)
    {
        $paginate = ($request->paginate) ? $request->paginate : 10;
        $tmtGaji = PegawaiTmtGaji::query()->when($request->cari,function ($query,$cari){
            $query->orWhere(DB::raw("DATE_FORMAT(tmt_gaji, '%d %b %Y')"),'like',"%{$cari}%");
            $query->orWhere(DB::raw("CONCAT('Rp. ', FORMAT(nominal, 0))"),'like',"%{$cari}%");
            $query->orWhere(DB::raw("CONCAT(nama_depan,' ',nama_belakang)"),'like',"%{$cari}%");
            $query->orWhere('tmt_gaji','like',"%{$cari}%");
            $query->orWhere('pegawai.nama_depan','like',"%{$cari}%");
            $query->orWhere('pegawai.nama_belakang','like',"%{$cari}%");
            $query->orWhere('gaji.nominal','like',"%{$cari}%");
        })
            ->join('pegawai','pegawai.id','=','pegawai_tmt_gaji.pegawai_id')
            ->join('gaji','gaji.id','=','pegawai_tmt_gaji.gaji_id')
            ->select('pegawai_tmt_gaji.id',DB::raw('CONCAT(nama_depan," " ,nama_belakang) AS nama_lengkap')
                ,DB::raw('CONCAT("Rp. ", FORMAT(gaji.nominal, 0)) AS nominal_gaji')
                ,DB::raw("DATE_FORMAT(tmt_gaji, '%d %b %Y') AS tmt_gaji_format"))->paginate($paginate);
        return response()->json($tmtGaji);
    }
}
