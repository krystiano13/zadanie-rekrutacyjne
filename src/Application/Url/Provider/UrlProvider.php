<?php

declare(strict_types=1);

namespace App\Application\Url\Provider;

use App\Domain\Entity\Url;
use App\Infrastructure\Url\QueryRepository;

final readonly class UrlProvider
{
    public function __construct(private QueryRepository $queryRepository)
    {
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
