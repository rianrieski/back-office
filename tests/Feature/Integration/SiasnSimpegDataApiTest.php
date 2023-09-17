<?php

use App\Integration\Siasn\Request\Simpeg\GetPnsDataUtama;
use App\Models\Siasn\SiasnPnsDataUtama;
use App\Services\SiasnSimpegService;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

describe('siasn simpeg data transaction', function () {
    beforeEach(function () {
        \Saloon\Laravel\Facades\Saloon::fake([
            '*' => function (PendingRequest $request) {
                $reflection = new ReflectionClass($request->getRequest());

                return MockResponse::fixture('Simpeg/' . $reflection->getShortName());
            },
        ]);
    });

    it('can fetch siasn pns data utama', function () {
        $service = new SiasnSimpegService();

        $service->fetchPnsDataUtama(198808042015021001);

        \Saloon\Laravel\Facades\Saloon::assertSent(GetPnsDataUtama::class);

        expect(SiasnPnsDataUtama::first()->nipBaru)->toEqual(198808042015021001);
    });
});
