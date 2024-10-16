<?php

namespace App\Tests\Action\Transaction;

use App\Domain\Entity\Transaction;
use App\Infrastructure\Repository\User\UserRepository;
use App\Tests\Factory\UserFactory;
use App\Tests\Factory\WalletFactory;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

/**
 * @group transaction
 */
class CreateTransactionPostActionTest extends WebTestCase
{
    use ResetDatabase, Factories;

    private const string ENDPOINT = '/api/v1/create/transaction';

    private UserRepository $userRepository;
    private KernelBrowser $client;
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testSuccessfulyCreateTransaction(): void
    {
        $user = UserFactory::createOne();
        $user2 = UserFactory::createOne();

        WalletFactory::createOne(['user' => $user, 'balance' => 100]);
        WalletFactory::createOne(['user' => $user2, 'balance' => 100]);

        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);
        $user2 = $this->userRepository->findOneBy(['id' => $user2->getId()]);

        $this->client->loginUser($user);

        $payload = [
            'payer' => $user->getId(),
            'payee' => $user2->getId(),
            'value' => 10
        ];

        // Act
        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );


        $transactionRepository = $this->entityManager->getRepository(Transaction::class);
        $transaction = $transactionRepository->findOneBy([
            'senderWallet' => $user->getWallet()->getId(),
            'receiverWallet' => $user2->getWallet()->getId(),
            'amount' => 10
        ]);

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->assertNotNull($transaction);
        $this->assertEquals($user->getId(), $transaction->getSenderWallet()->getUser()->getId());
        $this->assertEquals($user2->getId(), $transaction->getReceiverWallet()->getUser()->getId());
        $this->assertEquals(10, $transaction->getAmount());
        $this->assertEquals(90, $user->getWallet()->getBalance());
        $this->assertEquals(110, $user2->getWallet()->getBalance());
    }

    public function testEmptyPayload(): void
    {
        // Arrange
        $user = UserFactory::createOne();

        WalletFactory::createOne(['user' => $user, 'balance' => 100]);

        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);

        $this->client->loginUser($user);

        // Act
        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
        );

        // Assert
        $this->assertResponseStatusCodeSame(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $this->client->getResponse()->getStatusCode()
        );
    }

    public function testContentTypeIncorrect(): void
    {
        // Arrange
        $user = UserFactory::createOne();

        WalletFactory::createOne(['user' => $user, 'balance' => 100]);

        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);

        $this->client->loginUser($user);

        // Act
        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/pdf'],
        );

        // Assert
        $this->assertResponseStatusCodeSame(
            Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
            $this->client->getResponse()->getStatusCode()
        );
    }

    public function testPayloadIsNotJson(): void
    {
        // Arrange
        $user = UserFactory::createOne();

        WalletFactory::createOne(['user' => $user, 'balance' => 100]);

        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);

        $this->client->loginUser($user);

        $invalidJson = 'invalid json';

        // Act
        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: $invalidJson
        );

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function testEmptyPayer(): void
    {
        // Arrange
        $user = UserFactory::createOne();

        WalletFactory::createOne(['user' => $user, 'balance' => 100]);

        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);

        $this->client->loginUser($user);

        $payload = [
            'payee' => $user->getId(),
            'value' => 10
        ];

        // Act
        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );
        $response = json_decode($this->client->getResponse()->getContent());

        // Assert
        $this->assertResponseStatusCodeSame(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $this->client->getResponse()->getStatusCode()
        );
        $this->assertEquals("payer: This value should be of type int.", $response->detail);
    }

    public function testEmptyPayee(): void
    {
        // Arrange
        $user = UserFactory::createOne();

        WalletFactory::createOne(['user' => $user, 'balance' => 100]);

        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);

        $this->client->loginUser($user);

        $payload = [
            'payer' => $user->getId(),
            'value' => 10
        ];

        // Act
        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );
        $response = json_decode($this->client->getResponse()->getContent());

        // Assert
        $this->assertResponseStatusCodeSame(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $this->client->getResponse()->getStatusCode()
        );
        $this->assertEquals("payee: This value should be of type int.", $response->detail);
    }

    public function testEmptyValue(): void
    {
        // Arrange
        $user = UserFactory::createOne();

        WalletFactory::createOne(['user' => $user, 'balance' => 100]);

        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);

        $this->client->loginUser($user);

        $payload = [
            'payer' => $user->getId(),
            'payee' => $user->getId()
        ];

        // Act
        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );
        $response = json_decode($this->client->getResponse()->getContent());

        // Assert
        $this->assertResponseStatusCodeSame(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $this->client->getResponse()->getStatusCode()
        );
        $this->assertEquals("value: This value should be of type float.", $response->detail);
    }

    public function testInsufficientBalance(): void
    {
        // Arrange
        $user = UserFactory::createOne();

        WalletFactory::createOne(['user' => $user, 'balance' => 100]);

        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);

        $this->client->loginUser($user);

        $payload = [
            'payer' => $user->getId(),
            'payee' => $user->getId(),
            'value' => 50000
        ];

        // Act
        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );
        $response = json_decode($this->client->getResponse()->getContent());

        // Assert
        $this->assertResponseStatusCodeSame(
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $this->client->getResponse()->getStatusCode()
        );
        $this->assertEquals("Saldo insuficiente", $response->detail);
    }
}
