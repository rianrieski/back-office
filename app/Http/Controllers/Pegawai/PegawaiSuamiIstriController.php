<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaiSuamiIstriRequest;
use App\Models\JenisKawin;
use App\Models\Pegawai;
use App\Models\PegawaiSuamiIstri;
use App\Models\Pendidikan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PegawaiSuamiIstriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Pegawai/PegawaiSuamiIstri/Index', [
            'title' => 'Suami Istri'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Pegawai/PegawaiSuamiIstri/Create', [
            'title' => 'Tambah Suami/Istri',
            'pegawai' => Pegawai::getAllDataPegawai(),
            'pendidikan' => Pendidikan::select('id', 'nama')->get(),
            'jenis_kawin' => JenisKawin::select('id', 'nama')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PegawaiSuamiIstriRequest $request)
    {
        $suamiIstri = new PegawaiSuamiIstri();
        $suamiIstri->pegawai_id = $request->pegawai_id;
        $suamiIstri->nama = $request->nama;
        $suamiIstri->nik = $request->nik;
        $suamiIstri->tempat_lahir = $request->tempat_lahir;
        $suamiIstri->tanggal_lahir = $request->tanggal_lahir;
        $suamiIstri->tanggal_kawin = $request->tanggal_kawin;
        $suamiIstri->no_kartu = $request->no_kartu;
        $suamiIstri->is_pns = $request->is_pns;
        $suamiIstri->pendidikan_id = $request->pendidikan_id;
        $suamiIstri->pekerjaan = $request->pekerjaan;
        $suamiIstri->status_tunjangan = $request->status_tunjangan;
        $suamiIstri->no_sk_cerai = $request->no_sk_cerai;
        $suamiIstri->tmt_sk_cerai = $request->tmt_sk_cerai;
        $suamiIstri->jenis_kawin_id = $request->jenis_kawin_id;
        $suamiIstri->no_buku_nikah = $request->no_buku_nikah;
        try {
            DB::transaction(function () use ($request, $suamiIstri) {
                $suamiIstri->save();
                if ($request->file('media_foto_pasangan')) {
                    $suamiIstri->addMediaFromRequest('media_foto_pasangan')->toMediaCollection('media_foto_pasangan');
                }
                if ($request->file('media_buku_nikah')) {
                    $suamiIstri->addMediaFromRequest('media_buku_nikah')->toMediaCollection('media_buku_nikah');
                }
            });
            return redirect()->back()->with('success', 'suami/istri pegawai berhasil disimpan');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['query' => 'suami/istri pegawai gagal disimpan']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $suamiIstri = PegawaiSuamiIstri::where('pegawai_suami_istri.id', $id)
            ->join('pegawai', 'pegawai.id', '=', 'pegawai_suami_istri.pegawai_id')
            ->join('pendidikan', 'pendidikan.id', '=', 'pegawai_suami_istri.pendidikan_id')
            ->join('jenis_kawin', 'jenis_kawin.id', '=', 'pegawai_suami_istri.jenis_kawin_id')
            ->select(
                'pegawai_suami_istri.id',
                DB::raw('CONCAT(pegawai.nama_depan," " ,pegawai.nama_belakang) AS nama_lengkap'),
                'pendidikan.nama AS nama_pendidikan',
                'pegawai_suami_istri.nama AS nama',
                'pegawai_suami_istri.nik AS nik',
                'pegawai_suami_istri.tempat_lahir',
                DB::raw("DATE_FORMAT(pegawai_suami_istri.tanggal_lahir, '%d %b %Y') AS tanggal_lahir"),
                DB::raw("DATE_FORMAT(pegawai_suami_istri.tanggal_kawin, '%d %b %Y') AS tanggal_kawin"),
                'no_kartu',
                'pekerjaan',
                'no_sk_cerai',
                'tmt_sk_cerai',
                'jenis_kawin.nama AS jenis_kawin',
                'no_buku_nikah'
            )
            ->addSelect(DB::raw('CASE WHEN pegawai_suami_istri.status_tunjangan = 1 THEN "Aktif"
            WHEN pegawai_suami_istri.status_tunjangan = 0 THEN "Tidak Aktif" END AS status_tunjangan'))
            ->addSelect(DB::raw('CASE WHEN pegawai_suami_istri.is_pns = 1 THEN "Aktif"
            WHEN pegawai_suami_istri.is_pns = 0 THEN "Tidak Aktif" END AS is_pns'))
            ->first();
        $bukuNikah = $suamiIstri->getMedia("media_buku_nikah");
        $fotoPasangan = $suamiIstri->getMedia("media_foto_pasangan");

        if (count($bukuNikah) == 0) {
            $suamiIstri->media_buku_nikah = null;
        } else {
            $suamiIstri->media_buku_nikah = $bukuNikah[0]->getUrl();
        }
        if (count($fotoPasangan) == 0) {
            $suamiIstri->media_foto_pasangan = null;
        } else {
            $suamiIstri->media_foto_pasangan = $suamiIstri->getMedia("media_foto_pasangan")[0]->getUrl();
        }

        return response()->json($suamiIstri);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $suamiIstriDetail = PegawaiSuamiIstri::where('id', $id)->first();
        return Inertia::render('Pegawai/PegawaiSuamiIstri/Edit', [
            'title' => 'Edit Suami/Istri',
            'pegawai' => Pegawai::getAllDataPegawai(),
            'pendidikan' => Pendidikan::select('id', 'nama')->get(),
            'jenis_kawin' => JenisKawin::select('id', 'nama')->get(),
            'suamiIstriDetail' => $suamiIstriDetail
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PegawaiSuamiIstriRequest $request, string $id)
    {
        try {
            $suamiIstri = PegawaiSuamiIstri::where('id', $id)->first();
            if ($suamiIstri != null) {
                $suamiIstri->pegawai_id = $request->pegawai_id;
                $suamiIstri->nama = $request->nama;
                $suamiIstri->nik = $request->nik;
                $suamiIstri->tempat_lahir = $request->tempat_lahir;
                $suamiIstri->tanggal_lahir = $request->tanggal_lahir;
                $suamiIstri->tanggal_kawin = $request->tanggal_kawin;
                $suamiIstri->no_kartu = $request->no_kartu;
                $suamiIstri->is_pns = $request->is_pns;
                $suamiIstri->pendidikan_id = $request->pendidikan_id;
                $suamiIstri->pekerjaan = $request->pekerjaan;
                $suamiIstri->status_tunjangan = $request->status_tunjangan;
                $suamiIstri->no_sk_cerai = $request->no_sk_cerai;
                $suamiIstri->tmt_sk_cerai = $request->tmt_sk_cerai;
                $suamiIstri->jenis_kawin_id = $request->jenis_kawin_id;
                $suamiIstri->no_buku_nikah = $request->no_buku_nikah;
                DB::transaction(function () use ($suamiIstri, $request) {
                    $suamiIstri->save();
                    if ($request->file('media_foto_pasangan')) {
                        $suamiIstri->clearMediaCollection('media_foto_pasangan');
                        $suamiIstri->addMediaFromRequest('media_foto_pasangan')->toMediaCollection('media_foto_pasangan');
                    }
                    if ($request->file('media_buku_nikah')) {
                        $suamiIstri->clearMediaCollection('media_buku_nikah');
                        $suamiIstri->addMediaFromRequest('media_buku_nikah')->toMediaCollection('media_buku_nikah');
                    }
                });
                return redirect()->back()->with('success', 'riwayat diklat berhasil diubah');
            }
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['query' => 'riwayat diklat gagal diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $suamiIstri = PegawaiSuamiIstri::where('id', $id)->first();

        if ($suamiIstri == null) {
            return redirect()->back()->withErrors([
                'query' => 'data suami/istri gagal dihapus atau tidak ditemukan'
            ]);
        }
        try {
            DB::transaction(function () use ($suamiIstri) {
                if ($suamiIstri->hasMedia("media_buku_nikah")) {
                    $suamiIstri->getMedia("media_buku_nikah")[0]->delete();
                }
                if ($suamiIstri->hasMedia("media_foto_pasangan")) {
                    $suamiIstri->getMedia("media_foto_pasangan")[0]->delete();
                }
                $suamiIstri->delete();
            });
            return redirect()->back()->with('success', 'data suami/istri berhasil dihapus');
        } catch (QueryException $e) {
            return redirect()->withErrors(['queruy' => 'data suami/istri gagal dihapus']);
        }
    }
    public function getDataPegawaiSuamiIstri(Request $request)
    {
        $paginate = ($request->paginate) ? $request->paginate : 10;
        $pegawaiSuamiIstri = PegawaiSuamiIstri::query()->when($request->cari, function ($query, $cari) {
            $query->orWhere(DB::raw("CONCAT(nama_depan,' ',nama_belakang)"), 'like', "%{$cari}%");
            $query->orWhere('nama', 'like', "%{$cari}%");
            $query->orWhere('pegawai.nik', 'like', "%{$cari}%");
            $query->orWhere('status_tunjangan', 'like', "%{$cari}%");
            $query->orWhere(DB::raw('CASE WHEN pegawai_suami_istri.status_tunjangan = 1 THEN "Aktif" WHEN pegawai_suami_istri.status_tunjangan = 0 THEN "Tidak Aktif" END'), 'like', "{$cari}%");
        })
            ->join('pegawai', 'pegawai.id', '=', 'pegawai_suami_istri.pegawai_id')
            ->select(
                'pegawai_suami_istri.id',
                DB::raw('CONCAT(nama_depan," " ,nama_belakang) AS nama_lengkap'),
                'nama',
                'pegawai.nik'
            )
            ->addSelect(DB::raw('CASE WHEN pegawai_suami_istri.status_tunjangan = 1 THEN "Aktif" WHEN pegawai_suami_istri.status_tunjangan = 0 THEN "Tidak Aktif" END AS status_tunjangan'))
            ->paginate($paginate);
        return response()->json($pegawaiSuamiIstri);
    }
}
