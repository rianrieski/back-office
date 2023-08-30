<?php

namespace App\Integration\Siasn\Connector;

use App\Integration\Siasn\Authenticator\SiasnSimpegAuthenticator;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Connector;

class SiasnSimpegConnector extends Connector
{
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
