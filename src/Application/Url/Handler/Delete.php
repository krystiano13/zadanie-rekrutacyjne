<?php

declare(strict_types=1);

namespace App\Application\Url\Handler;

use App\Domain\Entity\Url;
use App\Infrastructure\Url\Repository;

final readonly class Delete
{
    public function __construct(private Repository $repository)
    {
    }

    public function handle(Url $url): void
    {
        $this->repository->remove($url);
    }
}
