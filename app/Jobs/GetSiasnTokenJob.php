<?php

namespace App\Jobs;

use App\Integration\Siasn\Request\CreateApimwsToken;
use App\Integration\Siasn\Request\CreateSiasnTokenRequest;
use App\Models\IntegrationToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetSiasnTokenJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle(): void
    {
        $siasnToken = (new CreateSiasnTokenRequest())->send()->dtoOrFail();

        IntegrationToken::updateOrCreate(
            ['token_type' => 'sso-siasn'],
            ['access_token' => $siasnToken->accessToken, 'expires_in' => $siasnToken->expiresIn]
        );

        $apimwsToken = (new CreateApimwsToken())->send()->dtoOrFail();

        IntegrationToken::updateOrCreate(
            ['token_type' => 'apimws-bkn'],
            ['access_token' => $apimwsToken->accessToken, 'expires_in' => $apimwsToken->expiresIn]
        );
    }
}
