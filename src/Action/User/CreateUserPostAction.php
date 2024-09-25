<?php

namespace App\Action\User;

use App\Domain\Service\User\UserServiceInterface;
use App\Infrastructure\Dto\User\CreateUserDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final readonly class CreateUserPostAction
{
    public function __construct(
        private UserServiceInterface $userService
    ) {
    }

    #[Route(path: "/api/v1/create/user", name: "api_user_post", methods: ["POST"], format: "json")]
    public function __invoke(#[MapRequestPayload(acceptFormat: "json")] CreateUserDTO $dto): JsonResponse
    {
        $this->userService->createUser($dto);

        return new JsonResponse(['message' => 'Usuário criado com sucesso'], Response::HTTP_CREATED);
    }
}
