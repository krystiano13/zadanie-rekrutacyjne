<?php

declare(strict_types=1);

namespace App\Application\Url\Handler;

use App\Application\Url\DTO\CreateUrlRequestDTO;
use App\Application\Url\Provider\UrlProvider;
use App\Domain\Entity\Url;
use App\Domain\Enum\ExpireTimeEnum;
use App\Infrastructure\Url\Repository;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final readonly class Create
{
    public function __construct(
        private Repository $repository,
        private UrlProvider $urlProvider,
    ) {
    }

    public function handle(CreateUrlRequestDTO $dto, string $shortUrl): void
    {
        $url = new Url();

        $url->setUrl($dto->url);
        $url->setCode($shortUrl);
        $url->setType($dto->type);

        if ($dto->expireTime) {
            switch ($dto->expireTime) {
                case ExpireTimeEnum::HOUR:
                    $url->setExpiresAt(new \DateTimeImmutable('+1 hour'));
                    break;
                case ExpireTimeEnum::DAY:
                    $url->setExpiresAt(new \DateTimeImmutable('+1 day'));
                    break;
                case ExpireTimeEnum::WEEK:
                    $url->setExpiresAt(new \DateTimeImmutable('+1 week'));
                    break;
            }
        }

        if ($dto->alias) {
            $isFree = $this->urlProvider->isAliasFree($dto->alias);

            if (!$isFree) {
                throw new UnprocessableEntityHttpException("Alias '{$dto->alias}' is not free");
            }

            $url->setAlias($dto->alias);
        }

        $this->repository->save($url);
    }
}
