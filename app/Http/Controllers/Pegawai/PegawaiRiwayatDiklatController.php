<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaiRiwayatDiklatRequest;
use App\Models\JenisDiklat;
use App\Models\Pegawai;
use App\Models\PegawaiRiwayatDiklat;
use App\Services\PegawaiService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class PegawaiRiwayatDiklatController extends Controller
{

    public function index()
    {
        return Inertia::render('Pegawai/PegawaiRiwayatDiklat/Index', [
            'title' => 'Diklat Pegawai',
            'diklat' => QueryBuilder::for(PegawaiRiwayatDiklat::class)
                ->with(['pegawai:id,nama', 'jenisDiklat:id,nama'])
                ->allowedFilters(['tanggal_mulai', 'penyelenggara', 'no_sertifikat',
                    // Filter by model relationship
                    AllowedFilter::callback('pegawai', fn(Builder $builder, $value) => $builder
                        ->whereRelation('pegawai', 'nama', 'like', "%$value%")),
                    AllowedFilter::callback('jenis_diklat', fn(Builder $builder, $value) => $builder
                        ->whereRelation('jenisDiklat', 'nama', 'like', "%$value%"))
                ])
                ->allowedSorts(['tanggal_mulai', 'penyelenggara', 'no_sertifikat',
                    // Sort by model relationship
                    AllowedSort::callback('pegawai', fn(Builder $builder, $val) => $builder->orderBy(Pegawai::select('nama')
                        ->whereColumn('pegawai.id', '=', 'pegawai_riwayat_diklat.pegawai_id'), $val ? 'DESC' : 'ASC')),
                    AllowedSort::callback('jenis_diklat', fn(Builder $builder, $val) => $builder->orderBy(JenisDiklat::select('nama')
                        ->whereColumn('jenis_diklat.id', '=', 'pegawai_riwayat_diklat.jenis_diklat_id'), $val ? 'DESC' : 'ASC'))
                ])
                ->paginate(request('per_page', 15))
                ->onEachSide(1)
                ->appends(request()->query())
        ]);
    }

    public function create()
    {
        return Inertia::render('Pegawai/PegawaiRiwayatDiklat/Create', [
            'title' => 'Tambah Riwayat Diklat',
            'pegawai' => fn() => PegawaiService::getNamaBySearch(),
            'jenis_diklat' => fn() => JenisDiklat::select('id', 'nama')->get()
        ]);
    }

    public function store(PegawaiRiwayatDiklatRequest $request)
    {
        $data = $request->validated();

        Arr::forget($data, 'media_sertifikat');

        $diklat = PegawaiRiwayatDiklat::create($data);

        $diklat->addMediaFromRequest('media_sertifikat')->toMediaCollection('media_sertifikat');

        return to_route('riwayat-diklat.index')->with('toast', [
            'message' => 'Riwayat diklat berhasil disimpan'
        ]);
    }

    public function show(string $id)
    {
        try {
            $riwayatDiklat = PegawaiRiwayatDiklat::where('pegawai_riwayat_diklat.id', $id)
                ->join('pegawai', 'pegawai.id', '=', 'pegawai_riwayat_diklat.pegawai_id')
                ->join('jenis_diklat', 'jenis_diklat.id', '=', 'pegawai_riwayat_diklat.jenis_diklat_id')
                ->select('pegawai_riwayat_diklat.id'
                    , DB::raw("DATE_FORMAT(tanggal_mulai, '%d %b %Y') AS tanggal_mulai")
                    , DB::raw("DATE_FORMAT(tanggal_akhir, '%d %b %Y') AS tanggal_akhir")
                    , 'lokasi'
                    , 'jam_pelajaran'
                    , 'penyelenggaran'
                    , DB::raw("DATE_FORMAT(tanggal_sertifikat, '%d %b %Y') AS tanggal_sertifikat")
                    , 'no_sertifikat'
                    , DB::raw('CONCAT(pegawai.nama_depan," " ,pegawai.nama_belakang) AS nama_lengkap')
                    , 'jenis_diklat.nama AS nama_diklat')
                ->first();
            $riwayatDiklat->media_sertifikat = $riwayatDiklat->getMedia("media_sertifikat")[0]->getUrl();
            if ($riwayatDiklat == null) {
                return response()->json(['status' => 404, 'message' => 'data tidak ditemukan'], 404);
            } else {
                return response()->json(['status' => 200, 'message' => 'OK', 'data' => $riwayatDiklat], 200);
            }
        } catch (QueryException $e) {
            return response()->json(['status' => 500, 'message' => 'kesalahan pada server'], 500);
        }
    }

    public function edit(string $id)
    {
        $pegawaiRiwayatDiklatDetail = PegawaiRiwayatDiklat::where('id', $id)->first();
        return Inertia::render('Pegawai/PegawaiRiwayatDiklat/Edit', [
            'title' => 'Edit Riwayat',
            'pegawai' => Pegawai::getAllDataPegawai(),
            'jenis_diklat' => JenisDiklat::select('id', 'nama')->get(),
            'pegawaiRiwayatDiklatDetail' => $pegawaiRiwayatDiklatDetail
        ]);
    }

    public function update(PegawaiRiwayatDiklatRequest $request, string $id)
    {
        try {
            $diklat = PegawaiRiwayatDiklat::where('id', $id)->first();
            if ($diklat != null) {
                $diklat->pegawai_id = $request->pegawai_id;
                $diklat->jenis_diklat_id = $request->jenis_diklat_id;
                $diklat->tanggal_mulai = $request->tanggal_mulai;
                $diklat->tanggal_akhir = $request->tanggal_akhir;
                $diklat->lokasi = $request->lokasi;
                $diklat->jam_pelajaran = $request->jam_pelajaran;
                $diklat->no_sertifikat = $request->no_sertifikat;
                $diklat->tanggal_sertifikat = $request->tanggal_sertifikat;
                $diklat->penyelenggaran = $request->penyelenggaran;
                DB::transaction(function () use ($diklat, $request) {
                    $diklat->save();
                    if ($request->file('media_sertifikat')) {
                        $diklat->clearMediaCollection('media_sertifikat');
                        $diklat->addMediaFromRequest('media_sertifikat')->toMediaCollection('media_sertifikat');
                    }
                });
                return redirect()->back()->with('success', 'riwayat diklat berhasil diubah');
            } else {
                return redirect()->back()->withErrors(['query' => 'riwayat diklat gagal diubah']);
            }
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['query' => 'riwayat diklat gagal diubah']);
        }
    }

    public function destroy(string $id)
    {
        $diklat = PegawaiRiwayatDiklat::where('id', $id)->first();

        if ($diklat == null) {
            return redirect()->back()->withErrors([
                'query' => 'riwayat diklat gagal dihapus atau tidak ditemukan'
            ]);
        }
        try {
            DB::transaction(function () use ($diklat) {
                if ($diklat->hasMedia("media_sertifikat")) {
                    $diklat->getMedia("media_sertifikat")[0]->delete();
                }
                $diklat->delete();
            });
            return redirect()->back()->with('success', 'riwayat diklat berhasil dihapus');
        } catch (QueryException $e) {
            return redirect()->withErrors(['queruy' => 'riwayat diklat gagal dihapus']);
        }
    }

    public function getDataRiwayatDiklat(Request $request)
    {
        $paginate = ($request->paginate) ? $request->paginate : 10;
        $riwayatDiklat = PegawaiRiwayatDiklat::query()->when($request->cari, function ($query, $cari) {
            $query->orWhere(DB::raw("DATE_FORMAT(tanggal_mulai, '%d %b %Y')"), 'like', "%{$cari}%");
            $query->orWhere(DB::raw("DATE_FORMAT(tanggal_akhir, '%d %b %Y')"), 'like', "%{$cari}%");
            $query->orWhere(DB::raw("CONCAT(nama_depan,' ',nama_belakang)"), 'like', "%{$cari}%");
            $query->orWhere('pegawai.nama_depan', 'like', "%{$cari}%");
            $query->orWhere('jenis_diklat.nama', 'like', "%{$cari}%");
            $query->orWhere('pegawai.nama_belakang', 'like', "%{$cari}%");
            $query->orWhere('tanggal_mulai', 'like', "%{$cari}%");
            $query->orWhere('tanggal_akhir', 'like', "%{$cari}%");
            $query->orWhere('jam_pelajaran', 'like', "%{$cari}%");
        })
            ->join('pegawai', 'pegawai.id', '=', 'pegawai_riwayat_diklat.pegawai_id')
            ->join('jenis_diklat', 'jenis_diklat.id', '=', 'pegawai_riwayat_diklat.jenis_diklat_id')
            ->select('pegawai_riwayat_diklat.id', DB::raw('CONCAT(nama_depan," " ,nama_belakang) AS nama_lengkap'), 'jenis_diklat.nama'
                , DB::raw("DATE_FORMAT(tanggal_mulai, '%d %b %Y') AS tanggal_mulai"), DB::raw("DATE_FORMAT(tanggal_akhir, '%d %b %Y') AS tanggal_akhir"), 'penyelenggaran', 'no_sertifikat')->paginate($paginate);
        return response()->json($riwayatDiklat);
    }
}
