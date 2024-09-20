<?php

namespace App\Infrastructure\Service\TransactionAuthorizer;

use App\Adapter\TransactionAuthorizer\TransactionAuthorizerGateway;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class TransactionAuthorizerService implements TransactionAuthorizerGateway
{
    public function __construct(
        private HttpClientInterface $client,
        private string $baseUrl
    ) {
    }

    public function authorize(): bool
    {
        try {
            $response = $this->client->request(
                method: 'GET',
                url: $this->baseUrl
            );

            $content = json_decode($response->getContent(), true);

            return $content['status'];
        } catch (
            ClientExceptionInterface
            | RedirectionExceptionInterface
            | ServerExceptionInterface
            | TransportExceptionInterface $e
        ) {
            return false;
        }
    }
}
