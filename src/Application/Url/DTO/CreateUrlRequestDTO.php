<?php

declare(strict_types=1);

namespace App\Application\Url\DTO;

use App\Domain\Enum\ExpireTimeEnum;
use App\Domain\Enum\UrlTypeEnum;

final readonly class CreateUrlRequestDTO
{
    public function __construct(
        public string $url,
        public UrlTypeEnum $type,
        public ?ExpireTimeEnum $expireTime = null,
        public ?string $alias = null,
    ) {
    }
}
