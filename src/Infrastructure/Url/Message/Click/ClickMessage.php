<?php

declare(strict_types=1);

namespace App\Infrastructure\Url\Message\Click;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage]
final readonly class ClickMessage
{
    public function __construct(private string $urlId)
    {
    }

    public function getUrlId(): string
    {
        return $this->urlId;
    }
}
