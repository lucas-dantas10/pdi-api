<?php

namespace App\Tests\Action\User;

use App\Domain\Enum\RoleUser\RoleUserEnum;
use App\Infrastructure\Repository\User\UserRepository;
use App\Tests\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

/**
 * @group user
 */
class CreateUserPostActionTest extends WebTestCase
{
    use ResetDatabase, Factories;

    private const string ENDPOINT = '/api/v1/create/user';

    private UserRepository $userRepository;
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
    }

    public function testSuccessfulyCreateUser(): void
    {
        $user = UserFactory::createOne();
        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);
        $this->client->loginUser($user);
        $payload = [
            'email' => 'QqgBZ@example.com',
            'full_name' => 'Teste Create User',
            'cpf' => '12345678901',
            'user_type' => RoleUserEnum::ROLE_COMMON->value,
            'password' => '123'
        ];

        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );
        $userCreated = $this->userRepository->findOneBy(['email' => "QqgBZ@example.com"]);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertNotNull($userCreated);
        $this->assertJson($this->client->getResponse()->getContent());
        $this->assertEquals("QqgBZ@example.com", $userCreated->getEmail());
        $this->assertEquals("Teste Create User", $userCreated->getFullName());
        $this->assertEquals("12345678901", $userCreated->getCpf());
        $this->assertEquals(RoleUserEnum::ROLE_COMMON->name, $userCreated->getRoles()['role']);
    }

    public function testEmptyPayload(): void
    {
        $user = UserFactory::createOne();
        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);
        $this->client->loginUser($user);
        $payload = [];

        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );
        $userCreated = $this->userRepository->findOneBy(['email' => "QqgBZ@example.com"]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertNull($userCreated);
    }

    public function testPayloadIsNotJson(): void
    {
        $user = UserFactory::createOne();
        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);
        $this->client->loginUser($user);
        $payload = "invalid json";

        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: $payload
        );
        $userCreated = $this->userRepository->findOneBy(['email' => "QqgBZ@example.com"]);

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertNull($userCreated);
    }

    public function testEmptyEmail(): void
    {
        $user = UserFactory::createOne();
        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);
        $this->client->loginUser($user);
        $payload = [
            'full_name' => 'Teste Create User',
            'cpf' => '12345678901',
            'user_type' => RoleUserEnum::ROLE_COMMON->value,
            'password' => '123'
        ];

        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );
        $userCreated = $this->userRepository->findOneBy(['email' => "QqgBZ@example.com"]);

        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertNull($userCreated);
        $this->assertEquals("email: This value should be of type string.", $response->detail);
    }

    public function testEmptyFullName(): void
    {
        $user = UserFactory::createOne();
        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);
        $this->client->loginUser($user);
        $payload = [
            'email' => 'QqgBZ@example.com',
            'cpf' => '12345678901',
            'user_type' => RoleUserEnum::ROLE_COMMON->value,
            'password' => '123'
        ];

        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );
        $userCreated = $this->userRepository->findOneBy(['email' => "QqgBZ@example.com"]);

        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertNull($userCreated);
        $this->assertEquals("fullName: This value should be of type string.", $response->detail);
    }

    public function testEmptyCpf(): void
    {
        $user = UserFactory::createOne();
        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);
        $this->client->loginUser($user);
        $payload = [
            'email' => 'QqgBZ@example.com',
            'full_name' => 'Teste Create User',
            'user_type' => RoleUserEnum::ROLE_COMMON->value,
            'password' => '123'
        ];

        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );
        $userCreated = $this->userRepository->findOneBy(['email' => "QqgBZ@example.com"]);

        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertNull($userCreated);
        $this->assertEquals("cpf: This value should be of type string.", $response->detail);
    }

    public function testEmptyUserType(): void
    {
        $user = UserFactory::createOne();
        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);
        $this->client->loginUser($user);
        $payload = [
            'email' => 'QqgBZ@example.com',
            'full_name' => 'Teste Create User',
            'cpf' => '12345678901',
            'password' => '123'
        ];

        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );
        $userCreated = $this->userRepository->findOneBy(['email' => "QqgBZ@example.com"]);

        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertNull($userCreated);
        $this->assertEquals("userType: This value should be of type int.", $response->detail);
    }

    public function testEmptyPassword(): void
    {
        $user = UserFactory::createOne();
        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);
        $this->client->loginUser($user);
        $payload = [
            'email' => 'QqgBZ@example.com',
            'full_name' => 'Teste Create User',
            'cpf' => '12345678901',
            'user_type' => RoleUserEnum::ROLE_COMMON->value,
        ];

        $this->client->request(
            Request::METHOD_POST,
            self::ENDPOINT,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );
        $userCreated = $this->userRepository->findOneBy(['email' => "QqgBZ@example.com"]);

        $response = json_decode($this->client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertNull($userCreated);
        $this->assertEquals("password: This value should be of type string.", $response->detail);
    }
}
