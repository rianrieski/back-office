<?php

namespace App\Jobs;

use App\Models\PegawaiRiwayatPenghargaan;
use App\Models\Siasn\SiasnPnsRwPenghargaan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncRiwayatPenghargaanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public SiasnPnsRwPenghargaan $siasnData)
    {
    }

    public function handle(): void
    {
        PegawaiRiwayatPenghargaan::updateOrCreate(['bkn_id' => $this->siasnData->id], [
            'pegawai_id' => $this->siasnData->siasnPegawai->pegawai->id,
            'penghargaan_id' => $this->siasnData->hargaId,
            'no_sk' => $this->siasnData->skNomor,
            'tanggal_sk' => !$this->siasnData->skDate ? null : date_create_from_format('d-m-Y', $this->siasnData->skDate)->format('Y-m-d'),
            'tahun' => $this->siasnData->tahun,
        ]);
        // TODO: download related file and store to database
    }
}
