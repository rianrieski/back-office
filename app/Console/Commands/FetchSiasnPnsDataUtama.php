<?php

namespace App\Console\Commands;

use App\Services\SiasnService;
use Illuminate\Console\Command;

class FetchSiasnPnsDataUtama extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siasn:fetch-pns-data-utama';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get PNS Data Utama from SIASN API';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        (new SiasnService())->fetchAllPnsDataUtama();
    }
}
