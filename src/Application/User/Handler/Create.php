<?php

declare(strict_types=1);

namespace App\Application\User\Handler;

use App\Domain\Entity\User;
use App\Infrastructure\User\Repository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

final readonly class Create
{
    public function __construct(
        private JWTTokenManagerInterface $tokenManager,
        private Repository $repository,
    ) {
    }

    public function handle(): string
    {
        $user = new User();
        $user->setExpiresAt(new \DateTimeImmutable('+30 days'));
        $token = $this->tokenManager->create($user);

        $this->repository->save($user);

        return $token;
    }
}
