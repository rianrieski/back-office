<?php

use App\Integration\Siasn\Request\Referensi\GetAgamaRequest;
use App\Integration\Siasn\Request\Referensi\GetAlasanHukDisRequest;
use App\Models\Siasn\Referensi\Agama;
use App\Models\Siasn\Referensi\AlasanHukDis;
use App\Services\SiasnReferensiService;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

describe('fetch referensi from siasn', function () {

    beforeEach(function () {
        \Saloon\Laravel\Facades\Saloon::fake([
            '*' => function (PendingRequest $pendingRequest) {
                $name = implode('/', array_filter([
                    parse_url($pendingRequest->getUrl(), PHP_URL_HOST),
                    mb_strtoupper($pendingRequest->getMethod()->value ?? 'GET'),
                    parse_url($pendingRequest->getUrl(), PHP_URL_PATH),
                    http_build_query(array_diff_key($pendingRequest->query()->all(), array_flip(['key', 'format']))),
                ]));

                return MockResponse::fixture($name);
            },
        ]);
    });

    it('can fetch agama and store to database', function () {
        $service = new SiasnReferensiService();

        $service->fetchAgama();

        \Saloon\Laravel\Facades\Saloon::assertSent(GetAgamaRequest::class);

        expect(Agama::count())->not->toBeEmpty();
    });

    it('can fetch alasan hukuman disiplin and store to database', function () {
        $service = new SiasnReferensiService();

        $service->fetchAlasanHukDis();

        \Saloon\Laravel\Facades\Saloon::assertSent(GetAlasanHukDisRequest::class);

        expect(AlasanHukDis::count())->not->toBeEmpty();
    });
});
