<?php

namespace App\Integration\Siasn\Connector;

use App\Integration\Siasn\Authenticator\SiasnSimpegAuthenticator;
use App\Integration\Siasn\Request\CreateSiasnTokenRequest;
use Saloon\Contracts\Authenticator;
use Saloon\Contracts\OAuthAuthenticator;
use Saloon\Contracts\Request;
use Saloon\Contracts\Response;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Traits\OAuth2\ClientCredentialsGrant;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class SiasnSimpegConnector extends Connector
{
    use AlwaysThrowOnErrors, ClientCredentialsGrant;

    public function __construct()
    {
//        $this->middleware()->onResponse(new RefreshTokenMiddleware);
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

    protected function resolveAccessTokenRequest(OAuthConfig $oauthConfig, array $scopes = [], string $scopeSeparator = ' '): Request
    {
        return new CreateSiasnTokenRequest($oauthConfig, $scopes, $scopeSeparator);
    }

    protected function createOAuthAuthenticatorFromResponse(Response $response): OAuthAuthenticator
    {
        $responseData = $response->object();
        dd($responseData);
//        $accessToken = $responseData->access_token;
//        $expires_at = $responseData->exp
    }
}
