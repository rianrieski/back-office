<?php

namespace App\Services;

use App\Integration\Siasn\Authenticator\SiasnSimpegAuthenticator;
use App\Integration\Siasn\Connector\SiasnSimpegConnector;
use App\Integration\Siasn\Request\Simpeg\GetPnsDataPasangan;
use App\Integration\Siasn\Request\Simpeg\GetPnsDataUtama;
use App\Integration\Siasn\Request\Simpeg\GetPnsRwPenghargaan;
use App\Models\Siasn\SiasnPnsDataUtama;
use App\Models\Siasn\SiasnPnsRwPenghargaan;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

class SiasnSimpegService
{
    public SiasnSimpegConnector $connector;
    private \Closure $resetToken;

    public function __construct()
    {
        $this->connector = new SiasnSimpegConnector();

        $this->connector->authenticate(new SiasnSimpegAuthenticator);

        $this->resetToken = function ($exception, $pendingRequest) {
            if (!$exception instanceof RequestException || $exception->getResponse()->status() !== 401) {
                return false;
            }

            $pendingRequest->authenticate(new SiasnSimpegAuthenticator);

            return true;
        };
    }

    public function fetchPnsDataUtama(string|int $nip): SiasnPnsDataUtama
    {
        $response = $this->connector->sendAndRetry(new GetPnsDataUtama($nip), 3, 100, $this->resetToken);

        $data = $response->json()['data'];

        return SiasnPnsDataUtama::updateOrCreate(
            ['id' => $data['id']],
            $data
        );
    }

    public function fetchAllPnsDataUtama(): void
    {
        foreach (PresensiService::getAllNip() as $nip) {
            try {
                $this->fetchPnsDataUtama($nip);
            } catch (NotFoundException $exception) {
                continue;
            }
        }
    }

//    TODO: fix function
    public function fetchPnsDataPasangan(string|int $nip)
    {
        $response = $this->connector->sendAndRetry(new GetPnsDataPasangan($nip), 3, 10, $this->resetToken);

        return $response->json();

//        $data = $response->json()['data'];

//        return SiasnPnsDataUtama::updateOrCreate(
//            ['id' => $data['id']],
//            $data
//        );
    }

    public function fetchPnsRwPenghargaan(string|int $nip): int
    {
        $response = $this->connector->sendAndRetry(new GetPnsRwPenghargaan($nip), 3, 10, $this->resetToken);

        $data = $response->json()['data'];

        if ($data === 'Data tidak ditemukan') {
            return 0;
        }

        foreach ($data as $row) {
            SiasnPnsRwPenghargaan::updateOrCreate(['ID' => $row['ID']], $row);
        }

        return count($data ?? []);
    }

    public function fetchAllPnsRwPenghargaan(): void
    {
        foreach (PresensiService::getAllNip() as $nip) {
            try {
                $this->fetchPnsRwPenghargaan($nip);
            } catch (NotFoundException $exception) {
                continue;
            }
        }
    }
}
