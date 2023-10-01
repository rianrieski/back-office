<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaiRiwayatPendidikanRequest;
use App\Models\Kota;
use App\Models\PegawaiRiwayatPendidikan;
use App\Models\Propinsi;
use App\Services\PegawaiService;
use App\Services\PendidikanService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class PegawaiRiwayatPendidikanController extends Controller
{
    public function index()
    {
        return Inertia::render('Pegawai/PegawaiRiwayatPendidikan/Index', [
            'title' => 'Riwayat Pendidikan Pegawai',
            'riwayatPendidikan' => fn() => QueryBuilder::for(PegawaiRiwayatPendidikan::class)
                ->with(['pegawai:id,nama', 'pendidikan:id,nama'])
                ->allowedFilters(['nama_instansi', 'no_ijazah', 'tanggal_ijazah'])
                ->allowedSorts(['nama_instansi', 'no_ijazah', 'tanggal_ijazah'])
                ->paginate(request('per_page', 15))
                ->onEachSide(1)
                ->appends(request()->query())
        ]);
    }

    public function create()
    {
        return Inertia::render('Pegawai/PegawaiRiwayatPendidikan/Create', [
            'title' => 'Rekam Riwayat Pendidikan',
            'pegawai' => fn() => PegawaiService::getNamaBySearch(),
            'pendidikan' => fn() => PendidikanService::getNamaBySearch(),
            'propinsi' => fn() => Propinsi::select('id', 'nama')->get(),
        ]);
    }

    public function store(PegawaiRiwayatPendidikanRequest $request)
    {
        $data = $request->validated();

        Arr::forget($data, 'media_ijazah');

        $riwayatPendidikan = PegawaiRiwayatPendidikan::create($data);

        if ($request->hasFile('media_ijazah')) {
            $riwayatPendidikan->addMediaFromRequest('media_ijazah')->toMediaCollection('media_ijazah');
        }

        return to_route('riwayat-pendidikan.index')->with('toast', ['message' => 'Riwayat pendidikan berhasil disimpan']);
    }

    public function edit(PegawaiRiwayatPendidikan $riwayat_pendidikan)
    {
        return Inertia::render('Pegawai/PegawaiRiwayatPendidikan/Edit', [
            'title' => 'Edit Riwayat Pendidikan',
            'riwayatPendidikan' => fn() => $riwayat_pendidikan,
            'currentPegawai' => fn() => $riwayat_pendidikan->pegawai()->select('id', 'nama')->first(),
            'pegawai' => fn() => PegawaiService::getNamaBySearch(),
            'pendidikan' => fn() => PendidikanService::getNamaBySearch(),
            'propinsi' => fn() => Propinsi::select('id', 'nama')->get(),
            'kota' => fn() => Kota::when($propinsi_id = request('propinsi_id'), fn(Builder $builder) => $builder
                ->where('propinsi_id', $propinsi_id), fn(Builder $builder) => $builder
                ->where('propinsi_id', $riwayat_pendidikan->propinsi_id))->get(),
        ]);
    }

    public function update(PegawaiRiwayatPendidikanRequest $request, PegawaiRiwayatPendidikan $riwayat_pendidikan)
    {
        $data = $request->validated();

        Arr::forget($data, 'media_ijazah');

        $riwayat_pendidikan->update($data);

        if ($request->hasFile('media_ijazah')) {
            $riwayat_pendidikan->clearMediaCollection('media_ijazah');
            $riwayat_pendidikan->addMediaFromRequest('media_ijazah')->toMediaCollection('media_ijazah');
        }

        return to_route('riwayat-pendidikan.index')->with('toast', [
            'message' => 'Riwayat pendidikan berhasil diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PegawaiRiwayatPendidikan $riwayat_pendidikan)
    {
        // File terkait riwayat pendidikan otomatis terhapus
        $riwayat_pendidikan->delete();

        return to_route('riwayat-pendidikan.index')
            ->with('toast', ['message' => 'Riwayat pendidikan berhasil dihapus']);
    }
}
