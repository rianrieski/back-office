<?php

namespace App\Integration\Siasn\Response;

use Saloon\Contracts\Response;

class ApimwsToken
{
    public function __construct(
        public string $accessToken,
        public string $scope,
        public string $tokenType,
        public string $expiresIn,
    ){
    }

    public static function fromResponse(Response $response): self
    {
        $data = $response->json();

        return new static($data['access_token'], $data['scope'], $data['token_type'], $data['expires_in']);
    }
}
