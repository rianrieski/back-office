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
        $diklat = PegawaiRiwayatDiklat::find(request('diklat_id'));

        return Inertia::render('Pegawai/PegawaiRiwayatDiklat/Index', [
            'title' => 'Diklat Pegawai',
            'media_sertifikat_url' => Inertia::lazy(fn() => $diklat?->getFirstMediaUrl('media_sertifikat')),
            'diklat' => fn() => QueryBuilder::for(PegawaiRiwayatDiklat::class)
                ->with(['pegawai:id,nama', 'jenisDiklat:id,nama'])
                ->allowedFilters(['tanggal_mulai', 'nama', 'penyelenggara',
                    // Filter by relationship
                    AllowedFilter::callback('pegawai', fn(Builder $builder, $value) => $builder
                        ->whereRelation('pegawai', 'nama', 'like', "%$value%")),
                    AllowedFilter::callback('jenis_diklat', fn(Builder $builder, $value) => $builder
                        ->whereRelation('jenisDiklat', 'nama', 'like', "%$value%"))
                ])
                ->allowedSorts(['tanggal_mulai', 'nama', 'penyelenggara',
                    // Sort by relationship
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

    public function update(PegawaiRiwayatDiklatRequest $request, PegawaiRiwayatDiklat $riwayat_diklat)
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

    public function destroy(PegawaiRiwayatDiklat $riwayat_diklat)
    {
        // File terkait diklat otomatis terhapus
        $riwayat_diklat->delete();

        return back()->with('toast', [
            'message' => 'Data riwayat diklat berhasil dihapus'
        ]);
    }
}
