<?php

namespace App\Integration\Siasn\Request;


use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetPnsDataOrtu extends Request
{
    protected Method $method = Method::GET;
    public function __construct(public string|int $nip)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/pns/data-ortu/' . $this->nip;
    }
}
