<?php

namespace App\Integration\Siasn\Request;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\SoloRequest;
use Saloon\Traits\Body\HasFormBody;
use Saloon\Traits\Plugins\AcceptsJson;

class CreateSiasnTokenRequest extends SoloRequest implements HasBody
{
    use HasFormBody, AcceptsJson;

    protected Method $method = Method::POST;
    public function resolveEndpoint(): string
    {
        return 'https://sso-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token';
    }

    protected function defaultBody(): array
    {
        return [
            'client_id' => config('services.sso-siasn.client_id'),
            'grant_type' => config('services.sso-siasn.grant_type'),
            'username' => config('services.sso-siasn.username'),
            'password' => config('services.sso-siasn.password')
        ];
    }

    public function createDtoFromResponse(Response $response): mixed
    {

    }

}
