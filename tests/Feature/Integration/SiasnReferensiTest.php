<?php

use App\Integration\Siasn\Connector\SiasnReferensiConnector;

describe('fetch referensi from siasn', function () {
    test('fetch agama', function () {
        $this->withoutExceptionHandling();

//        \Saloon\Laravel\Facades\Saloon::fake([
//            GetApimwsTokenRequest::class => MockResponse::fixture('test/apimws-token'),
//            GetAgamaRequest::class => MockResponse::fixture('ref/agama'),
//        ]);

//        SiasnReferensiService::createToken();

        $connector = new SiasnReferensiConnector();

        $authenticator = $connector->getAccessToken(returnResponse: true);

        dd($authenticator);

//        $response = $connector->sendAndRetry(new GetAgamaRequest(), 2, 1, function ($exception, PendingRequest $pendingRequest) {
//            dd($pendingRequest);
//        });
//        dd($response->getRequest());
    });
});
