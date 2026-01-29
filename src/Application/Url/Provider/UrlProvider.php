<?php

declare(strict_types=1);

namespace App\Application\Url\Provider;

use App\Domain\Entity\Url;
use App\Domain\Entity\User;
use App\Domain\Enum\UrlTypeEnum;
use App\Infrastructure\Url\QueryRepository;

final readonly class UrlProvider
{
    public function __construct(private QueryRepository $queryRepository)
    {
    }

    public function isAliasFree(string $alias): bool
    {
        return $this->queryRepository->findOneBy([
            'alias' => $alias
        ]) !== null;
    }

    /**
     * @return Url[]
     */
    public function loadByUser(User $user): array
    {
        return $this->queryRepository->findBy([
            'user' => $user->getId(),
        ]);
    }

    /**
     * @return Url[]
     */
    public function loadAllPublic(): array
    {
        return $this->queryRepository->findBy([
            'type' => UrlTypeEnum::PUBLIC
        ]);
    }

    /**
     * @return Url[]
     */
    public function loadAll(): array
    {
        return $this->queryRepository->findAll();
    }

    public function loadById(string $id): ?Url
    {
        return $this->queryRepository->find($id);
    }
}
