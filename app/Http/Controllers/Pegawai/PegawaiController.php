<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaiRequest;
use App\Models\Pegawai;
use App\Models\Agama;
use App\Models\JenisKawin;
use App\Models\JenisPegawai;
use App\Models\StatusPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if ($request->perPage) {
        //     $perPage = $request->perPage;
        // } else {
        //     $perPage = 10;
        // }

        // $queryPegawai = Pegawai::query()
        //     ->when($request->cari, function ($query, $cari) {
        //         $query->where('nip', 'like', '%' . $cari . '%')
        //             ->orWhere('nama_depan', 'like', '%' . $cari . '%')
        //             ->orWhere('nama_belakang', 'like', '%' . $cari . '%');
        //     })->orderBy('id', 'desc');

        // return inertia('Pegawai/PegawaiProfil/Index', [
        //     'pegawai' => $queryPegawai
        //         ->paginate($perPage)
        //         ->appends($request->only(['cari', 'perPage'])),
        //     'filter' => $request->only(['cari', 'perPage']),
        // ]);

        $data =
            QueryBuilder::for(Pegawai::class)
            ->allowedFilters([
                'nip', 'status_dinas',
                AllowedFilter::callback('nama', function (Builder $query, $value) {
                    $query->where('nama_depan', 'like', "%$value%")
                        ->orWhere(
                            'nama_belakang',
                            'like',
                            "%$value%"
                        );
                }),
            ])
            ->allowedSorts([
                'nip', 'status_dinas',
                AllowedSort::callback('nama', function (Builder $query, $value) {
                    $query->orderBy('nama_depan', $value ? 'DESC' : 'ASC');
                })
            ])
            ->paginate(request('per_page', 10))
            ->onEachSide(1)
            ->appends(request()->query());

        return Inertia::render('Pegawai/PegawaiProfil/Index', [
            'pegawai' => fn () => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agama = Agama::all();
        $statusNikah = JenisKawin::all();
        $jenisPegawai = JenisPegawai::all();
        $statusPegawai = StatusPegawai::all();

        return inertia('Pegawai/PegawaiProfil/Create', [
            'agama' => $agama,
            'statusNikah' => $statusNikah,
            'jenisPegawai' => $jenisPegawai,
            'statusPegawai' => $statusPegawai,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PegawaiRequest $request)
    {
        // dd($request->all());

        $validated = $request->validated();

        Arr::pull($validated, 'media_kartu_pegawai');
        Arr::pull($validated, 'media_foto_pegawai');

        $pegawai = Pegawai::create($validated);

        $pegawai->addMediaFromRequest('media_foto_pegawai')->toMediaCollection('media_foto_pegawai');
        $pegawai->addMediaFromRequest('media_kartu_pegawai')->toMediaCollection('media_kartu_pegawai');

        return redirect()->route('profil_pegawai.index')->with('success', 'Data pegawai berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pegawai = Pegawai::with([
            'agama:id,nama',
            'jenis_kawin:id,nama',
            'jenis_pegawai:id,nama',
            'status_pegawai:id,nama',
        ])->where('id', $id)->first();

        $fotoPegawai = $pegawai->getMedia("media_foto_pegawai");

        if (count($fotoPegawai) == 0) {
            $urlFotoPegawai = url(asset('assets/noPhotoFound.png'));
        } else {
            $urlFotoPegawai = $fotoPegawai[0]->getUrl();
        }

        $kartuPegawai = $pegawai->getMedia("media_kartu_pegawai");

        if (count($kartuPegawai) == 0) {
            $urlKartuPegawai = url(asset('assets/noPhotoFound.png'));
        } else {
            $urlKartuPegawai = $kartuPegawai[0]->getUrl();
        }

        return inertia(
            'Pegawai/PegawaiProfil/Show',
            [
                'pegawai' => $pegawai,
                'media_foto_pegawai' => $urlFotoPegawai,
                'media_kartu_pegawai' => $urlKartuPegawai,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pegawai = Pegawai::with([
            'agama:id,nama',
            'jenis_kawin:id,nama',
            'jenis_pegawai:id,nama',
            'status_pegawai:id,nama',
        ])->where('id', $id)->first();

        $agama = Agama::all();
        $statusNikah = JenisKawin::all();
        $jenisPegawai = JenisPegawai::all();
        $statusPegawai = StatusPegawai::all();

        $fotoPegawai = $pegawai->getMedia("media_foto_pegawai");

        if (count($fotoPegawai) == 0) {
            $urlFotoPegawai = url(asset('assets/noPhotoFound.png'));
        } else {
            $urlFotoPegawai = $fotoPegawai[0]->getUrl();
        }

        $kartuPegawai = $pegawai->getMedia("media_kartu_pegawai");

        if (count($kartuPegawai) == 0) {
            $urlKartuPegawai = url(asset('assets/noPhotoFound.png'));
        } else {
            $urlKartuPegawai = $kartuPegawai[0]->getUrl();
        }

        return inertia(
            'Pegawai/PegawaiProfil/Edit',
            [
                'pegawai' => $pegawai,
                'agama' => fn () => $agama,
                'statusNikah' => fn () => $statusNikah,
                'jenisPegawai' => fn () => $jenisPegawai,
                'statusPegawai' => fn () => $statusPegawai,
                'media_foto_pegawai' => $urlFotoPegawai,
                'media_kartu_pegawai' => $urlKartuPegawai,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PegawaiRequest $request, $id)
    {
        $validated = $request->validated();

        Arr::pull($validated, 'media_kartu_pegawai');
        Arr::pull($validated, 'media_foto_pegawai');

        $pegawai = Pegawai::findOrFail($id);

        $pegawai->update($validated);

        if ($request->validated('media_foto_pegawai')) {
            $pegawai->clearMediaCollection('media_foto_pegawai');
            $pegawai->addMediaFromRequest('media_foto_pegawai')->toMediaCollection('media_foto_pegawai');
        }

        if ($request->validated('media_kartu_pegawai')) {
            $pegawai->clearMediaCollection('media_kartu_pegawai');
            $pegawai->addMediaFromRequest('media_kartu_pegawai')->toMediaCollection('media_kartu_pegawai');
        }

        return redirect()->route('profil_pegawai.index')->with('success', 'Data pegawai berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        if ($pegawai->hasMedia("media_foto_pegawai")) {
            $pegawai->getMedia("media_foto_pegawai")[0]->delete();
        }

        if ($pegawai->hasMedia("media_kartu_pegawai")) {
            $pegawai->getMedia("media_kartu_pegawai")[0]->delete();
        }

        $pegawai->delete();

        return redirect()->route('profil_pegawai.index')->with('success', 'Data pegawai berhasil dihapus!');
    }
}
