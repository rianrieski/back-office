<?php

namespace App\Services;

use App\Integration\Siasn\Connector\SiasnReferensiConnector;
use App\Integration\Siasn\Request\Referensi\GetAgamaRequest;
use App\Integration\Siasn\Request\Referensi\GetAlasanHukDisRequest;
use App\Models\Siasn\Referensi\Agama;
use App\Models\Siasn\Referensi\AlasanHukDis;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\PendingRequest;

class SiasnReferensiService
{
    public SiasnReferensiConnector $connector;
    private \Closure $resetToken;

    public function __construct()
    {
        $this->connector = new SiasnReferensiConnector();

        $this->resetToken = function ($exception, PendingRequest $pendingRequest) {
            if (!$exception instanceof RequestException || $exception->getResponse()->status() !== 401) {
                return false;
            }

            $authenticator = $this->connector->getAccessToken();

            $pendingRequest->authenticate($authenticator);

            return true;
        };
    }

    public function fetchAgama(): void
    {
        $response = $this->connector->sendAndRetry(new GetAgamaRequest(), 3, 100, $this->resetToken);

        $results = $response->json('results');

        Agama::upsert($results, ['id']);
    }

    public function fetchAlasanHukDis(): void
    {
        $response = $this->connector->sendAndRetry(new GetAlasanHukDisRequest(), 3, 100, $this->resetToken);

        $result = $response->json('results');

        AlasanHukDis::upsert($result, ['id']);
    }
}
