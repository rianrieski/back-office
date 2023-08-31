<?php

use App\Integration\Siasn\Connector\SiasnSimpegConnector;
use App\Integration\Siasn\Request\GetPnsDataUtama;
use App\Jobs\GetSiasnTokenJob;

it('get siasn pns data utama', function () {
    GetSiasnTokenJob::dispatch();
    $connector = new SiasnSimpegConnector();

    $response = $connector->send(new GetPnsDataUtama(198808042015021001));

    dd($response->json());
});
