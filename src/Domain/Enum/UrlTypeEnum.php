<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum UrlTypeEnum: string
{
    case PUBLIC = 'public';
    case PRIVATE = 'private';
}
