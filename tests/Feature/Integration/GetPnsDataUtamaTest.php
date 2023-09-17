<?php

use App\Integration\Siasn\Request\CreateSiasnTokenRequest;
use App\Integration\Siasn\Request\GetApimwsTokenRequest;
use App\Integration\Siasn\Request\GetPnsDataUtama;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    \Saloon\Laravel\Facades\Saloon::fake([
        GetPnsDataUtama::class => MockResponse::fixture('pns/data-utama'),
        CreateSiasnTokenRequest::class => MockResponse::fixture('token/siasn-token'),
        GetApimwsTokenRequest::class => MockResponse::fixture('token/apimws-token')
    ]);
});

it('can fetch siasn pns data utama', function () {

//    $count = \Illuminate\Support\Facades\DB::connection('db_siap')->table('Agama')->count();

//    phpinfo();

//    dd($count);
//    GetSiasnTokenJob::dispatchSync();

//    $connector = new SiasnSimpegConnector;

//    $response = $connector->sendAndRetry(new GetPnsDataUtama(198808042015021001), 2, 10, function ($exception, PendingRequest $pendingRequest) {
//        dd($exception);
//    });

//    $service = new SiasnService();
//
//    $response = $service->fetchPnsDataUtama(198808042015021001);

//    dd($response);
});
