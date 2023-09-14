<?php

use App\Integration\Siasn\Connector\SiasnSimpegConnector;
use App\Integration\Siasn\Request\CreateApimwsToken;
use App\Integration\Siasn\Request\CreateSiasnTokenRequest;
use App\Integration\Siasn\Request\GetPnsDataUtama;
use App\Jobs\GetSiasnTokenJob;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
   \Saloon\Laravel\Facades\Saloon::fake([
       GetPnsDataUtama::class => MockResponse::fixture('pns/data-utama'),
       CreateSiasnTokenRequest::class => MockResponse::fixture('token/siasn-token'),
       CreateApimwsToken::class => MockResponse::fixture('token/apimws-token')
   ]);
});

it('can fetch siasn pns data utama', function () {
    GetSiasnTokenJob::dispatchSync();

    $connector = new SiasnSimpegConnector;

//    $response = $connector->sendAndRetry(new GetPnsDataUtama(198808042015021001), 2, 10, function ($exception, PendingRequest $pendingRequest) {
//        dd($exception);
//    });


//    $service = new SiasnService();
//
//    $response = $service->fetchPnsDataUtama(198808042015021001);

    dd($response);
});
