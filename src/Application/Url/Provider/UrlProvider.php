<?php

declare(strict_types=1);

namespace App\Application\Url\Provider;

use App\Domain\Entity\Url;
use App\Domain\Entity\User;
use App\Infrastructure\Common\DTO\PaginationDTO;
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

        if (count($result) > 0) {
            return $result[0];
        }

        return null;
    }

    public function isAliasFree(string $alias): bool
    {
        return 0 === count(
            $this->queryRepository->findByAlias($alias)->getResult()
        );
    }

    /**
     * @return Url[]
     */
    public function loadByUser(User $user, PaginationDTO $dto): array
    {
        return $this->queryRepository->findByUser($user, $dto)->getResult();
    }

    /**
     * @return Url[]
     */
    public function loadAllPublic(PaginationDTO $dto): array
    {
        return $this->queryRepository->findAllPublic($dto)->getResult();
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
