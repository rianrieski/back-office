<?php

namespace App\Integration\Siasn\Connector;

use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Traits\OAuth2\ClientCredentialsGrant;

class BknSsoConnector extends Connector
{
    use ClientCredentialsGrant;
    public function resolveBaseUrl(): string
    {
        return 'https://sso-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token';
    }

    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId(config('services.sso-siasn.client_id'));
    }

}
