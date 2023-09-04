<?php

namespace App\Integration\Siasn\Response;

use Saloon\Contracts\Response;

class SiasnPnsDataPasangan
{
    public function __construct(
        public string $pnsId,
        public string $orangId,
        public ?string $ayahId,
        public ?string $ibuId,
        public ?string $nama,
        public ?string $namaKtp,
        public ?string $gelarDepan,
        public ?string $gelarBlk,
        public ?string $tempatLahir,
        public ?string $tglLahir,
        public ?string $aktaMeninggal,
        public ?string $tglMeninggal,
        public ?string $jenisKelamin,
        public ?string $jenisAnak,
        public ?string $statusHidup,
        public ?string $jenisKawinId,
        public ?string $statusNikah,
        public ?string $dataPernikahanId,
        public ?string $tglMenikah,
        public ?string $aktaMenikah,
        public ?string $tglCerai,
        public ?string $aktaCerai,
        public ?string $posisi,
        public ?string $status,
        public ?string $isPns,
        public ?string $noSkPensiun,
    ){
    }

    public static function fromResponse(Response $response): static
    {
        $data = $response->json()['data'];

        return new static(
            pnsId: $data['idPns'],
            orangId: $data[]
        );
    }
}
