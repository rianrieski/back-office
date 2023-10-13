<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaiRiwayatPenghargaanRequest;
use App\Models\PegawaiRiwayatPenghargaan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PegawaiRiwayatPenghargaanController extends Controller
{
    public function index()
    {
        return Inertia::render('Pegawai/PegawaiRiwayatPenghargaan/Index', [
            'riwayat' => fn() => QueryBuilder::for(PegawaiRiwayatPenghargaan::class)
                ->with(['pegawai:id,nama_depan,nama_belakang', 'penghargaan:id,nama'])
                ->allowedFilters([
                    AllowedFilter::callback('keyword', fn(Builder $query, $value) => $query
                        ->whereHas('pegawai', fn(Builder $builder) => $builder
                            ->where('nama_depan', 'like', "%$value%")
                            ->orWhere('nama_belakang', 'like', "%$value%")))
                ])
                ->paginate(request('per_page', 15))
                ->appends(request()->query())
        ]);
    }

    public function store(PegawaiRiwayatPenghargaanRequest $request)
    {
        $data = $request->validated();

        Arr::forget($data, 'media_sk');

        $riwayat = PegawaiRiwayatPenghargaan::create($data);

        if ($request->has('media_sk')) {
            $riwayat->addMediaFromRequest('media_sk')->toMediaCollection('media_sk');
        }

        return to_route('riwayat-penghargaan.index')
            ->with('toast', ['message' => 'Data berhasil disimpan']);
    }

    public function update(PegawaiRiwayatPenghargaanRequest $request, PegawaiRiwayatPenghargaan $riwayat_penghargaan)
    {
        $data = $request->validated();

        Arr::forget($data, 'media_sk');

        $riwayat_penghargaan->update($data);

        if ($request->has('media_sk')) {
            $riwayat_penghargaan->clearMediaCollection('media_sk');
            $riwayat_penghargaan->addMediaFromRequest('media_sk')->toMediaCollection('media_sk');
        }

        return to_route('riwayat-penghargaan.index')
            ->with('toast', ['message' => 'Data berhasil disimpan']);
    }

    public function destroy(PegawaiRiwayatPenghargaan $riwayat_penghargaan)
    {
        $riwayat_penghargaan->delete();

        return to_route('riwayat-penghargaan.index')
            ->with('toast', ['message' => 'Data berhasil dihapus']);
    }
}
