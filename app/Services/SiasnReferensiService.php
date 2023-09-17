<?php

namespace App\Services;

use App\Integration\Siasn\Authenticator\SiasnReferensiAuthenticator;
use App\Integration\Siasn\Connector\SiasnReferensiConnector;
use App\Integration\Siasn\Request\GetApimwsTokenRequest;
use App\Integration\Siasn\Request\Referensi\GetAgamaRequest;
use App\Integration\Siasn\Request\Referensi\GetAlasanHukDisRequest;
use App\Models\IntegrationToken;
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

            self::createToken();

            $pendingRequest->authenticate(new SiasnReferensiAuthenticator());

            return true;
        };
    }

    public static function createToken(): void
    {
        $apimwsToken = (new GetApimwsTokenRequest())->send()->dtoOrFail();

        IntegrationToken::updateOrCreate(
            ['token_type' => 'apimws-bkn'],
            ['access_token' => $apimwsToken->accessToken, 'expires_in' => $apimwsToken->expiresIn]
        );
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
