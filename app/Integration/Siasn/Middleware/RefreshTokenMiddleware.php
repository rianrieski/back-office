<?php

namespace App\Integration\Siasn\Middleware;

use App\Jobs\GetSiasnTokenJob;
use Saloon\Contracts\Response;
use Saloon\Contracts\ResponseMiddleware;

class RefreshTokenMiddleware implements ResponseMiddleware
{
    public function __invoke(Response $response)
    {
        dd($response->status());

        if ($response->status() === 401) {
            GetSiasnTokenJob::dispatchSync();
        }
    }
}
