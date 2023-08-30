<?php

namespace App\Integration\Siasn\Response;


use Saloon\Contracts\Response;

class SiasnToken
{
    public function __construct(
        public string $accessToken,
        public int $expiresIn,
        public int $refreshExpiresIn,
        public string $refreshToken,
        public string $tokenType,
        public int $notBeforePolicy,
        public string $sessionState,
        public string $scope
    ){
    }

    public static function fromResponse(Response $response): self
    {
        $data = $response->json();

        return new static($data['access_token'], $data['expires_in'], $data['$refresh_expires_in'], $data['refresh_token'], $data['token_type'], $data['not_before_policy'], $data['session_state'], $data['scope']);
    }
}
