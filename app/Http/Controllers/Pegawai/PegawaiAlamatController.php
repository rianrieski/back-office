<?php

namespace App\Http\Controllers\Pegawai;

use App\Filters\FilterPegawaiAlamat;
use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaiAlamatRequest;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Pegawai;
use App\Models\PegawaiAlamat;
use App\Models\Propinsi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PegawaiAlamatController extends Controller
{
    public function index()
    {
        return Inertia::render('Pegawai/PegawaiAlamat/Index', [
            'pegawaiAlamat' => fn() => QueryBuilder::for(PegawaiAlamat::class)
                ->allowedFilters([
                    AllowedFilter::custom('keyword', new FilterPegawaiAlamat)
                ])
                ->with(['pegawai:id,nama', 'propinsi', 'kota', 'kecamatan', 'desa'])
                ->paginate(request('per_page', 15))
                ->onEachSide(1)
                ->appends(request()->query()),
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'propinsi_id' => 'numeric',
            'kota_id' => 'numeric',
            'kecamatan_id' => 'numeric',
        ]);

        return Inertia::render('Pegawai/PegawaiAlamat/Create', [
            'title' => 'Tambah Alamat',
            'pegawai' => fn() => Pegawai::select('id', 'nama')->whereNull('tanggal_berhenti')->get(),
            'propinsi' => fn() => Propinsi::all(),
            'kota' => Inertia::lazy(fn() => Kota::where('propinsi_id', $request->get('propinsi_id'))->get()),
            'kecamatan' => Inertia::lazy(fn() => Kecamatan::where('kota_id', $request->get('kota_id'))->get()),
            'desa' => Inertia::lazy(fn() => Desa::where('kecamatan_id', $request->get('kecamatan_id'))->get()),
        ]);
    }

    public function store(PegawaiAlamatRequest $request)
    {
        $pegawaiAlamat = PegawaiAlamat::where('pegawai_id', $request->pegawai_id)->get();

        if (count($pegawaiAlamat) >= 2) {
            return back()->withErrors([
                'pegawai_id' => 'Pegawai sudah memiliki dua alamat'
            ]);
        }

        foreach ($pegawaiAlamat as $alamat) {
            if ($alamat->tipe_alamat === $request->tipe_alamat) {
                return back()->withErrors([
                    'tipe_alamat' => 'Pegawai sudah memiliki alamat ' . $alamat->tipe_alamat
                ]);
            }
        }

        PegawaiAlamat::create($request->validated());

        return to_route('alamat.index')->with('toast', [
            'message' => 'Alamat berhasil disimpan',
        ]);
    }

    public function edit(Request $request, string $alamat)
    {
        $pegawaiAlamat = PegawaiAlamat::where('id', $alamat)->first();
        if ($pegawaiAlamat == null) {
            return redirect()->back()->withErrors(['query' => 'alamat pegawai tidak valid atau tidak ditemukan']);
            return redirect()->back()->withErrors(['query' => 'tidak dapat menampilkan form edit']);
        }
        $kota = Kota::select('id', 'nama', 'propinsi_id')->where('propinsi_id', $pegawaiAlamat->propinsi_id)->get();
        $kecamatan = Kecamatan::select('id', 'nama', 'kota_id')->where('kota_id', $pegawaiAlamat->kota_id)->get();
        $desa = Desa::select('id', 'nama', 'kecamatan_id')->where('kecamatan_id', $pegawaiAlamat->kecamatan_id)->get();
        $pegawai = Pegawai::where('id', $pegawaiAlamat->pegawai_id)->select('nama_depan', 'nama_belakang')->first();
        $propinsi = Propinsi::select('id', 'nama')->get();
        if ($request->propinsi_id) {
            $kota = Kota::select('id', 'nama', 'propinsi_id')->where('propinsi_id', $request->propinsi_id)->get();
        }
        if ($request->kota_id) {
            $kecamatan = Kecamatan::select('id', 'nama', 'kota_id')->where('kota_id', $request->kota_id)->get();
        }
        if ($request->kecamatan_id) {
            $desa = Desa::select('id', 'nama', 'kecamatan_id')->where('kecamatan_id', $request->kecamatan_id)->get();
        }
        return Inertia::render('Pegawai/PegawaiAlamat/Edit', [
            'pegawaiAlamat' => $pegawaiAlamat,
            'title' => 'Ubah Alamat',
            'pegawai' => fn() => $pegawai,
            'propinsi' => fn() => $propinsi,
            'kota' => fn() => $kota,
            'kecamatan' => fn() => $kecamatan,
            'desa' => fn() => $desa
        ]);
    }

    public function update(PegawaiAlamatRequest $request, string $id)
    {
        $alamat = PegawaiAlamat::where('id', $id)->first();
        $alamat->pegawai_id = $request->pegawai_id;
        $alamat->tipe_alamat = $request->tipe_alamat;
        $alamat->propinsi_id = $request->propinsi_id;
        $alamat->kota_id = $request->kota_id;
        $alamat->kecamatan_id = $request->kecamatan_id;
        $alamat->desa_id = $request->desa_id;
        $alamat->kode_pos = $request->kode_pos;
        $alamat->alamat = $request->alamat;
        try {
            $alamat->save();
            return redirect()->back()->with('success', 'Data alamat berhasil diubah');
        } catch (QueryException $e) {
            Log::error('terjadi kesalahan pada koneksi database');
            return redirect()->back()->withErrors([
                'query' => 'data alamat gagal disimpan'
            ]);
        }
    }

    public function destroy(PegawaiAlamat $alamat)
    {
        $alamat->delete();

        return back()->with('toast', [
            'message' => 'Data alamat berhasil dihapus'
        ]);
    }
}
