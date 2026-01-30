<?php

declare(strict_types=1);

namespace App\Application\User\Provider;

use App\Domain\Entity\User;
use App\Infrastructure\User\QueryRepository;

readonly class UserProvider
{
    public function __construct(private QueryRepository $repository)
    {
    }

    public function loadById(string $id): ?User
    {
        return $this->repository->find($id);
    }

    /**
     * @return User[]
     */
    public function loadAll(): array
    {
        return $this->repository->findAll();
    }
}
