<?php

namespace App\Integration\Siasn\Authenticator;

use App\Integration\Siasn\Request\CreateSiasnTokenRequest;
use App\Models\IntegrationToken;
use Saloon\Contracts\Authenticator;
use Saloon\Contracts\PendingRequest;

class SiasnReferensiAuthenticator implements Authenticator
{
    public function set(PendingRequest $pendingRequest): void
    {
        if ($pendingRequest->getRequest() instanceof CreateSiasnTokenRequest) {
            return;
        }

        $apimws = IntegrationToken::where('token_type', '=', 'apimws-bkn')->first();

        $pendingRequest->headers()
            ->add('Authorization', 'Bearer ' . $apimws?->access_token);
    }
}
