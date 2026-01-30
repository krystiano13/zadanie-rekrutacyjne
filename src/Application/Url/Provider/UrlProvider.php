<?php

declare(strict_types=1);

namespace App\Application\Url\Provider;

use App\Domain\Entity\Url;
use App\Domain\Entity\User;
use App\Infrastructure\Url\QueryRepository;

final readonly class UrlProvider
{
    public function __construct(private QueryRepository $queryRepository)
    {
    }

    public function loadByShortCode(string $shortCode): ?Url
    {
        $result = $this->queryRepository->findByShortCode($shortCode)
            ->getResult();

        if (count($result) > 0)
        {
            return $result[0];
        }

        return null;
    }

    public function isAliasFree(string $alias): bool
    {
        return count(
            $this->queryRepository->findByAlias($alias)->getResult()
        ) === 0;
    }

    /**
     * @return Url[]
     */
    public function loadByUser(User $user): array
    {
        return $this->queryRepository->findByUser($user)->getResult();
    }

    /**
     * @return Url[]
     */
    public function loadAllPublic(): array
    {
        return $this->queryRepository->findAllPublic()->getResult();
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
