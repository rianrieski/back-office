<?php

namespace App\Integration\Siasn\Connector;

use App\Integration\Siasn\Request\GetApimwsTokenRequest;
use Saloon\Contracts\OAuthAuthenticator;
use Saloon\Contracts\Request;
use Saloon\Contracts\Response;
use Saloon\Contracts\Sender;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Http\Senders\GuzzleSender;
use Saloon\Traits\OAuth2\ClientCredentialsGrant;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class SiasnReferensiConnector extends Connector
{
    use AlwaysThrowOnErrors, ClientCredentialsGrant;

    public function resolveBaseUrl(): string
    {
        return 'https://apimws.bkn.go.id:8243/referensi_siasn/1';
    }

    protected function defaultSender(): Sender
    {
        return resolve(GuzzleSender::class);
    }

    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId('client_id')
            ->setClientSecret('my-client-secret')
            ->setDefaultScopes(['default'])
            ->setTokenEndpoint('https://apimws.bkn.go.id/oauth2/token');
//            ->setRequestModifier(function (GetApimwsTokenRequest $request) {
//                $request->
//            });
    }

    protected function resolveAccessTokenRequest(OAuthConfig $oauthConfig, array $scopes = [], string $scopeSeparator = ' '): Request
    {
        return new GetApimwsTokenRequest();
    }

    protected function createOAuthAuthenticatorFromResponse(Response $response, string $fallbackRefreshToken = null): OAuthAuthenticator
    {
        dd($response->object());
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
