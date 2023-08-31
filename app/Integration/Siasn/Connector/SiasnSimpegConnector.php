<?php

namespace App\Integration\Siasn\Connector;

use App\Integration\Siasn\Authenticator\SiasnSimpegAuthenticator;
use App\Jobs\GetSiasnTokenJob;
use Saloon\Contracts\Authenticator;
use Saloon\Contracts\Response;
use Saloon\Http\Connector;
use Saloon\Traits\OAuth2\ClientCredentialsGrant;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class SiasnSimpegConnector extends Connector
{
    use AlwaysThrowOnErrors, ClientCredentialsGrant;

    public function __construct()
    {
        $this->middleware()->onResponse(function (Response $response) {
            if ($response->status() === 401) {
                GetSiasnTokenJob::dispatchSync();

                $response->getRequest()->authenticate(new SiasnSimpegAuthenticator);
            }
        });
    }

    public function resolveBaseUrl(): string
    {
        return 'https://apimws.bkn.go.id:8243/apisiasn/1.0';
    }

    protected function defaultAuth(): ?Authenticator
    {
        return new SiasnSimpegAuthenticator;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
