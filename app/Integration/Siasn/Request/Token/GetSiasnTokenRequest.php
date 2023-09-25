<?php

namespace App\Integration\Siasn\Request\Token;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasFormBody;

class GetSiasnTokenRequest extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    public function __construct(public int $timeout = 60)
    {
    }

    public function resolveEndpoint(): string
    {
        return 'https://sso-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token';
    }

    protected function defaultConfig(): array
    {
        return [
            'timeout' => $this->timeout
        ];
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
}
