<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\DateFormat;
use Spatie\LaravelData\Data;

class SiasnPenghargaanData extends Data
{
    public function __construct(
        public string  $hargaId,
        public string  $pnsOrangId,
        #[DateFormat('dd-mm-yyyy')]
        public string  $skDate,
        public string  $skNomor,
        public ?string $id = null,
        public ?array  $path = null,
    )
    {
    }
}
