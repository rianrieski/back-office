<?php

namespace App\Integration\Siasn\Authenticator;

use App\Integration\Siasn\Request\CreateSiasnTokenRequest;
use App\Models\IntegrationToken;
use Saloon\Contracts\Authenticator;
use Saloon\Contracts\PendingRequest;

class SiasnSimpegAuthenticator implements Authenticator
{
    public function set(PendingRequest $pendingRequest): void
    {
        if ($pendingRequest->getRequest() instanceof CreateSiasnTokenRequest) {
            return;
        }

        $apimws = IntegrationToken::where('token_type', '=', 'apimws-bkn')->first();
        $siasn = IntegrationToken::where('token_type', '=', 'sso-siasn')->first();

        $pendingRequest->headers()
            ->add('Authorization', 'Bearer ' . $apimws?->access_token)
            ->add('Auth', 'Bearer ' . $siasn?->access_token);
    }
}
