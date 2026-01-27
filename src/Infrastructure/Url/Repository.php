<?php

declare(strict_types=1);

namespace App\Infrastructure\Url;

use App\Domain\Entity\Url;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Url>
 */
final class Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Url::class);
    }

    public function save(Url $url): void
    {
        $this->getEntityManager()->persist($url);
        $this->getEntityManager()->flush();
    }

    public function remove(Url $url): void
    {
        $url->setDeletedAt(new \DateTimeImmutable());

        $this->getEntityManager()->persist($url);
        $this->getEntityManager()->flush();
    }
}
