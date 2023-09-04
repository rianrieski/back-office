<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\HirarkiUnitKerja;
use App\Models\UnitKerja;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class HirarkiUnitKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('HirarkiUnitKerja/Index',[
            'title'=>'Hirarki Unit Kerja',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('HirarkiUnitKerja/Create',[
            'title'=>'Tambah Hirarki Unit Kerja',
            'unitKerja' =>UnitKerja::select('id','nama')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'child_unit_kerja_id'=>['required','exists:unit_kerja,id','not_in:1'],
            'parent_unit_kerja_id'=>['required','exists:unit_kerja,id'],
        ],
        [
            'child_unit_kerja_id.required'=>'unit kerja harus diisi',
            'child_unit_kerja_id.exists'=>'unit kerja tidak valid',
            'child_unit_kerja_id.not_in'=>'tingkat unit kerja harus dibawah Badan Standardisasi Nasional',
            'parent_unit_kerja_id.required'=>'atasan langsung harus diisi',
            'parent_unit_kerja_id.exists'=>'atasan langsung tidak valid',
        ]);
        $checkExist = HirarkiUnitKerja::where('child_unit_kerja_id',$request->child_unit_kerja_id)
            ->where('parent_unit_kerja_id',$request->parent_unit_kerja_id)->count();
        if ($checkExist != 0)
        {
            return redirect()->back()->withErrors([
                'child_unit_kerja_id'=>'unit kerja dan atasan langsung sudah ada',
                'parent_unit_kerja_id'=>'unit kerja dan atasan langsung sudah ada',
            ]);
        }
        $hirarki = new HirarkiUnitKerja();
        $hirarki->child_unit_kerja_id = $request->child_unit_kerja_id;
        $hirarki->parent_unit_kerja_id = $request->parent_unit_kerja_id;
        try {
            $hirarki->save();
            return redirect()->back()->with('success','hirarki berhasil disimpan');
        }catch (QueryException $e){
            Log::error('terjadi kesalahan pada query atau koneksi database');
            return redirect()->back()->withErrors(['query' => 'hirarki gagal disimpan']);
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
        $hirarki = HirarkiUnitKerja::where('id',$id)->first();
       if ($hirarki == null){
           return redirect()->back()->withErrors(['query' => 'hirarki unit kerja tidak valid atau tidak ditemukan']);
       }
       return Inertia::render('HirarkiUnitKerja/Edit',[
           'title'=>'Ubah Hirarki Unit Kerja',
           'hirarkiUnitKerja' =>$hirarki,
           'unitKerja' => UnitKerja::select('id','nama')->get()
       ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'child_unit_kerja_id'=>['required','exists:unit_kerja,id','not_in:1'],
            'parent_unit_kerja_id'=>['required','exists:unit_kerja,id'],
        ],[
            'child_unit_kerja_id.required'=>'unit kerja harus diisi',
            'child_unit_kerja_id.exists'=>'unit kerja tidak valid',
            'child_unit_kerja_id.not_in'=>'tingkat unit kerja harus dibawah Badan Standardisasi Nasional',
            'parent_unit_kerja_id.required'=>'atasan langsung harus diisi',
            'parent_unit_kerja_id.exists'=>'atasan langsung tidak valid',
        ]);
        $checkExist = HirarkiUnitKerja::where('child_unit_kerja_id',$request->child_unit_kerja_id)
            ->where('parent_unit_kerja_id',$request->parent_unit_kerja_id)->count();
        if ($checkExist != 0)
        {
            return redirect()->back()->withErrors([
                'child_unit_kerja_id'=>'unit kerja dan atasan langsung sudah ada',
                'parent_unit_kerja_id'=>'unit kerja dan atasan langsung sudah ada',
            ]);
        }
        $hirarki = HirarkiUnitKerja::where('id',$id)->first();
        $hirarki->child_unit_kerja_id = $request->child_unit_kerja_id;
        $hirarki->parent_unit_kerja_id = $request->parent_unit_kerja_id;
        try {
            $hirarki->save();
            return redirect()->back()->with('success','hirarki berhasil disimpan');
        }catch (QueryException $e){
            Log::error('terjadi kesalahan pada query atau koneksi database');
            return redirect()->back()->withErrors(['query' => 'hirarki gagal disimpan']);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hirarki = HirarkiUnitKerja::where('id',$id)->first();
        if($hirarki == null){
            return redirect()->back()->withErrors(['quere'=>'hirarki unit kerja gagal dihapus']);
        }
        try {
            $hirarki->delete();
            return redirect()->back()->with('success','hirarki unit kerja berhasil dihapus');
        }catch (QueryException $e){
            Log::error('terjadi kesalahan pada query atau koneksi database');
            return redirect()->back()->withErrors(['quere'=>'hirarki unit kerja gagal dihapus']);
        }
    }

    /**
     * Get All Data Hirarki Unit Kerja
     */
    public function getDataHirarkiUnitKerja(Request $request){
        $paginate = ($request->paginate) ? $request->paginate : 10;
        $hirarkiUnitKerja = HirarkiUnitKerja::query()->when($request->cari,function ($query,$cari){
            $query->orWhere('parent.nama','like',"%{$cari}%");
            $query->orWhere('child.nama','like',"%{$cari}%");
        })
            ->join('unit_kerja as child','hirarki_unit_kerja.child_unit_kerja_id','=','child.id')
            ->join('unit_kerja as parent','hirarki_unit_kerja.parent_unit_kerja_id','=','parent.id')
            ->select('hirarki_unit_kerja.id','child.nama as nama_child','parent.nama as nama_parent')
            ->orderBy('hirarki_unit_kerja.id','ASC')
            ->paginate($paginate);
        return response()->json($hirarkiUnitKerja);
    }
}
