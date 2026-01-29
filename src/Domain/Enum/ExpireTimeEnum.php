<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum ExpireTimeEnum: string
{
    case HOUR = '1h';
    case DAY = '1d';
    case WEEK = '1t';
}
