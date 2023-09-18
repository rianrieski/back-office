<?php

use App\Integration\Siasn\Request\Simpeg\GetPnsDataPasangan;
use App\Integration\Siasn\Request\Simpeg\GetPnsDataUtama;
use App\Models\Siasn\SiasnPnsDataPasangan;
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

        $service->fetchPnsDataUtama(199111182019031005);

        \Saloon\Laravel\Facades\Saloon::assertSent(GetPnsDataUtama::class);

        expect(SiasnPnsDataUtama::first()->nipBaru)->toEqual(199111182019031005);
    });

    it('can fetch siasn pns data pasangan', function () {
        $service = new SiasnSimpegService();

        $service->fetchPnsDataPasangan(199111182019031005);

        \Saloon\Laravel\Facades\Saloon::assertSent(GetPnsDataPasangan::class);

        expect(SiasnPnsDataPasangan::count())->not->toBeEmpty();
    });
});
