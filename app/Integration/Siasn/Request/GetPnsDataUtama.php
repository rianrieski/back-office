<?php

namespace App\Integration\Siasn\Request;

use App\Integration\Siasn\Connector\SiasnSimpegConnector;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\HasConnector;

class GetPnsDataUtama extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;
    protected string $connector = SiasnSimpegConnector::class;

    public function __construct(protected string $nip)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/pns/data-utama/'. $this->nip;
    }
}
