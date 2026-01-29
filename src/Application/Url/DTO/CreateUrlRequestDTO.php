<?php

declare(strict_types=1);

namespace App\Application\Url\DTO;

use App\Domain\Enum\ExpireTimeEnum;
use App\Domain\Enum\UrlTypeEnum;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateUrlRequestDTO
{
    public function __construct(
        #[Assert\Url]
        public string $url,
        public UrlTypeEnum $type,
        public ?ExpireTimeEnum $expireTime = null,
        public ?string $alias = null,
    ) {
    }
}
