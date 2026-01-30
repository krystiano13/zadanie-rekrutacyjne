<?php

declare(strict_types=1);

namespace App\Application\User\Controller;

use App\Application\User\Handler\Create;
use App\Domain\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api/session', name: 'api_session_')]
final class Controller extends AbstractController
{
    #[Route(path: '/', name: 'get', methods: ['GET'])]
    public function index(): JsonResponse
    {
        try {
            /** @var User|null $user */
            $user = $this->getUser();

            if (
                !$user instanceof User
            ) {
                throw new UnauthorizedHttpException('Unauthorized');
            }

            return $this->json([
                'user' => [
                    'id' => $user->getId(),
                    'expires_at' => $user->getExpiresAt(),
                ],
            ]);
        } catch (UnauthorizedHttpException $exception) {
            return $this->json([
                'error' => 'Unauthorized',
            ], 401);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    #[Route(path: '/', name: 'create', methods: ['POST'])]
    public function create(Create $createHandler): JsonResponse
    {
        $token = $createHandler->handle();

        return $this->json([
            'token' => $token,
        ]);
    }
}
