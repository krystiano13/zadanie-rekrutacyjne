<?php

declare(strict_types=1);

namespace App\Infrastructure\Url;

use App\Domain\Entity\Url;
use App\Domain\Entity\User;
use App\Domain\Enum\UrlTypeEnum;
use App\Infrastructure\Common\DTO\PaginationDTO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Url>
 */
final class QueryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Url::class);
    }

    public function findByShortCode(string $shortCode): Query
    {
        return $this->createQueryBuilder('u')
            ->where('(u.code = :shortCode OR u.alias = :shortCode)')
            ->andWhere('u.deletedAt IS NULL')
            ->andWhere('(u.expiresAt IS NULL OR u.expiresAt > :now)')
            ->setParameter('shortCode', $shortCode)
            ->setParameter('now', new \DateTime())
            ->getQuery();
    }

    public function findByAlias(string $alias): Query
    {
        return $this->createQueryBuilder('u')
            ->where('(u.alias = :alias)')
            ->andWhere('u.deletedAt IS NULL')
            ->andWhere('(u.expiresAt IS NULL OR u.expiresAt > :now)')
            ->setParameter('alias', $alias)
            ->setParameter('now', new \DateTime())
            ->getQuery();
    }

    public function findByUser(User $user, PaginationDTO $dto): Query
    {
        $pageIndex = $dto->page - 1;

        return $this->createQueryBuilder('u')
            ->where('(u.user = :user)')
            ->andWhere('u.deletedAt IS NULL')
            ->andWhere('(u.expiresAt IS NULL OR u.expiresAt > :now)')
            ->setParameter('user', $user)
            ->setParameter('now', new \DateTime())
            ->setFirstResult($pageIndex * $dto->perPage)
            ->setMaxResults($dto->perPage)
            ->getQuery();
    }

    public function findAllPublic(PaginationDTO $dto): Query
    {
        $pageIndex = $dto->page - 1;

        return $this->createQueryBuilder('u')
            ->where('(u.type = :type)')
            ->andWhere('u.deletedAt IS NULL')
            ->andWhere('(u.expiresAt IS NULL OR u.expiresAt > :now)')
            ->setParameter('type', UrlTypeEnum::PUBLIC)
            ->setParameter('now', new \DateTime())
            ->setFirstResult($pageIndex * $dto->perPage)
            ->setMaxResults($dto->perPage)
            ->getQuery();
    }
}
