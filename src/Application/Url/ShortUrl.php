<?php

declare(strict_types=1);

namespace App\Application\Url;

final readonly class ShortUrl
{
    public function shortenUrl(string $url): string
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('Invalid URL');
        }

        return substr(
            base64_encode(
                sha1(
                    $url
                    .
                    uniqid(
                        random_bytes(32),
                        true
                    )
                )
            ),
            0,
            8
        );
    }
}
