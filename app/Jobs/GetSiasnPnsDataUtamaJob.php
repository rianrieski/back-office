<?php

namespace App\Jobs;

use App\Integration\Siasn\Authenticator\SiasnSimpegAuthenticator;
use App\Integration\Siasn\Connector\SiasnSimpegConnector;
use App\Integration\Siasn\Request\GetPnsDataUtama;
use App\Models\Siasn\SiasnPnsDataUtama;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Saloon\Exceptions\Request\RequestException;

class GetSiasnPnsDataUtamaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string|int $nip)
    {
    }

    public function handle(): void
    {
        $connector = new SiasnSimpegConnector();

        $response = $connector->sendAndRetry(new GetPnsDataUtama($this->nip), 3, 10, function ($exception, $pendingRequest) {
            if (! $exception instanceof RequestException || $exception->getResponse()->status() !== 401) {
                return false;
            }

            GetSiasnTokenJob::dispatchSync();

            $pendingRequest->authenticate(new SiasnSimpegAuthenticator);

            return true;
        });

        $data = $response->json()['data'];

        SiasnPnsDataUtama::updateOrCreate(
            ['id' => $data['id']],
            $data
        );
    }
}
