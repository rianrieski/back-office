<?php

namespace App\Services;

use App\Data\SiasnPenghargaanData;
use App\Data\SiasnPnsDataOrtuData;
use App\Data\SiasnPnsDataPasanganData;
use App\Integration\Siasn\Authenticator\SiasnSimpegAuthenticator;
use App\Integration\Siasn\Connector\SiasnSimpegConnector;
use App\Integration\Siasn\Request\Simpeg\GetPnsDataOrtu;
use App\Integration\Siasn\Request\Simpeg\GetPnsDataPasangan;
use App\Integration\Siasn\Request\Simpeg\GetPnsDataUtama;
use App\Integration\Siasn\Request\Simpeg\GetPnsRwPenghargaan;
use App\Integration\Siasn\Request\Simpeg\PostPenghargaan;
use App\Integration\Siasn\Request\Token\GetApimwsTokenRequest;
use App\Integration\Siasn\Request\Token\GetSiasnTokenRequest;
use App\Jobs\GetSiasnPnsDataUtamaJob;
use App\Models\Siasn\SiasnPnsDataOrtu;
use App\Models\Siasn\SiasnPnsDataPasangan;
use App\Models\Siasn\SiasnPnsDataUtama;
use App\Models\Siasn\SiasnPnsRwPenghargaan;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use ReflectionException;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Saloon\Exceptions\Request\ClientException;
use Saloon\Exceptions\Request\FatalRequestException;
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
        $response = $this->connector->sendAndRetry(new GetPnsDataUtama($nip), 3, 5000, $this->resetToken);

        $data = $response->json()['data'];

        return SiasnPnsDataUtama::updateOrCreate(
            ['id' => $data['id']],
            $data
        );
    }

    public function fetchAllPnsDataUtama(bool $sync = true): void
    {
        foreach (SiapService::getAllNip() as $nip) {

            if (!$sync) {
                GetSiasnPnsDataUtamaJob::dispatch($nip);
            } else {
                try {
                    $this->fetchPnsDataUtama($nip);
                } catch (NotFoundException $exception) {
                    continue;
                }
            }
        }
    }

    public function fetchPnsDataPasangan(string|int $nip): void
    {
        $response = $this->connector->sendAndRetry(new GetPnsDataPasangan($nip), 3, 5000, $this->resetToken);

        $data = $response->json()['data'];

        if ((bool)Arr::get($data, 'listPasangan')) {
            foreach ($data['listPasangan'] as $pasangan) {
                $object = SiasnPnsDataPasanganData::fromResponse($data['idPns'], $pasangan);

                SiasnPnsDataPasangan::updateOrCreate(
                    ['idPns' => $object->idPns, 'orangId' => $object->orangId],
                    $object->toArray()
                );
            }
        }
    }

    public function fetchAllPnsDataPasangan(): void
    {
        foreach (SiapService::getAllNip() as $nip) {
            try {
                $this->fetchPnsDataPasangan($nip);
            } catch (NotFoundException $exception) {
                continue;
            }
        }
    }

    public function fetchPnsRwPenghargaan(string|int $nip): void
    {
        $response = $this->connector->sendAndRetry(new GetPnsRwPenghargaan($nip), 3, 5000, $this->resetToken);

        $data = $response->json()['data'];

        if ($data === 'Data tidak ditemukan') {
            return;
        }

        foreach ($data as $row) {
            SiasnPnsRwPenghargaan::updateOrCreate(['ID' => $row['ID']], $row);
        }
    }

    public function fetchAllPnsRwPenghargaan(): void
    {
        foreach (SiapService::getAllNip() as $nip) {
            try {
                $this->fetchPnsRwPenghargaan($nip);
            } catch (NotFoundException $exception) {
                continue;
            }
        }
    }

    public function fetchPnsDataOrtu(string|int $nip): void
    {
        $response = $this->connector->sendAndRetry(new GetPnsDataOrtu($nip), 3, 5000, $this->resetToken);

        $object = SiasnPnsDataOrtuData::fromResponse($response->json('data'));

        SiasnPnsDataOrtu::updateOrCreate(
            ['idPns' => $object->idPns, 'ayahId' => $object->ayahId, 'ibuId' => $object->ibuId],
            $object->toArray()
        );
    }

    public function fetchAllPnsDataOrtu(): void
    {
        foreach (SiapService::getAllNip() as $nip) {
            try {
                $this->fetchPnsDataOrtu($nip);
            } catch (ClientException $exception) {
                continue;
            }
        }
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ClientException
     * @throws ReflectionException
     * @throws FatalRequestException
     * @throws PendingRequestException
     * @throws RequestException
     */
    public function postPenghargaan(SiasnPenghargaanData $data): void
    {
        $response = $this->connector->sendAndRetry(new PostPenghargaan($data), 3, 1000, $this->resetToken);

        if (!$response->json('success')) {
            throw new ClientException($response, $response->json('message'));
        }
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws HttpClientException
     * @throws PendingRequestException
     */
    public function uploadFile($filePath, int|string $id_ref_dokumen)
    {
        $url = config('services.apimws-bkn.base_url') . '/upload-dok';

        $stream = fopen($filePath, 'r');

        $siasnToken = $this->connector->send(new GetSiasnTokenRequest());
        $apimws = $this->connector->send(new GetApimwsTokenRequest());

        $response = Http::withHeaders([
            'Auth' => 'bearer ' . $siasnToken->json('access_token'),
            'Authorization' => 'Bearer ' . $apimws->json('access_token'),
        ])
            ->attach('file', $stream)
            ->acceptJson()
            ->post($url, [
                'id_ref_dokumen' => $id_ref_dokumen,
            ]);

        if (!$response->json('code')) {
            throw new HttpClientException($response->json('message'));
        }

        return $response->json('data');
    }
}
