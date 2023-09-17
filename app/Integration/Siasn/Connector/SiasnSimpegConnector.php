<?php

namespace App\Integration\Siasn\Connector;

use App\Integration\Siasn\Authenticator\SiasnSimpegAuthenticator;
use Saloon\Contracts\Authenticator;
use Saloon\Contracts\Sender;
use Saloon\Http\Connector;
use Saloon\Http\Senders\GuzzleSender;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class SiasnSimpegConnector extends Connector
{
    use AlwaysThrowOnErrors;

    public function resolveBaseUrl(): string
    {
        return 'https://apimws.bkn.go.id:8243/apisiasn/1.0';
    }

    protected function defaultSender(): Sender
    {
        return resolve(GuzzleSender::class);
    }

    protected function defaultAuth(): Authenticator
    {
        return new SiasnSimpegAuthenticator();
    }
}
