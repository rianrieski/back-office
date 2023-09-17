<?php

namespace App\Integration\Siasn\Request\Referensi;

use App\Models\IntegrationToken;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAgamaRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/agama';
    }

    protected function defaultHeaders(): array
    {
        $apimws = IntegrationToken::where('token_type', '=', 'apimws-bkn')->first();

        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $apimws->access_token
        ];
    }
}
