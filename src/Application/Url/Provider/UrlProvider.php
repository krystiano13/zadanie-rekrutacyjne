<?php

declare(strict_types=1);

namespace App\Application\Url\Provider;

use App\Domain\Entity\Url;
use App\Domain\Entity\User;
use App\Infrastructure\Common\DTO\PaginationDTO;
use App\Infrastructure\Url\QueryRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

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
        $query = $this->queryRepository->findByUser($user, $dto);
        return $this->paginateUrls($query, $dto);
    }

    /**
     * @return Url[]
     */
    public function loadAllPublic(PaginationDTO $dto): array
    {
        $query = $this->queryRepository->findAllPublic($dto);
        return $this->paginateUrls($query, $dto);
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

    /**
     * @return array<mixed>
     */
    private function paginateUrls(Query $query, PaginationDTO $dto): array {
        $paginator = new Paginator($query);

        $total = $paginator->count();
        $totalPages = (int) ceil($total / $dto->perPage);

        $result = [];

        foreach ($paginator as $url) {
            $result[] = $url;
        }

        return [
            'items' => $result,
            'pagination' => [
                'page' => $dto->page,
                'perPage' => $dto->perPage,
                'total' => $total,
                'totalPages' => $totalPages,
            ],
        ];
    }
}
