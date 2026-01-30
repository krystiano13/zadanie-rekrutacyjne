<?php

declare(strict_types=1);

namespace App\Tests\Unit\Url;

use App\Application\Url\ShortUrl;
use PHPUnit\Framework\TestCase;

class ShortUrlTest extends TestCase
{
    private ShortUrl $shortUrl;

    public function setUp(): void
    {
        parent::setUp();
        $this->shortUrl = new ShortUrl();
    }

    public function testShortUrlReturnProperCode(): void
    {
        $url = 'https://example.com';
        $result = $this->shortUrl->shortenUrl($url);

        $this->assertIsString($result);
        $this->assertEquals(8, strlen($result));
    }

    public function testShortUrlThrowsExceptionOnInvalidUrl(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid URL');

        $invalidUrl = 'invalid url';
        $this->shortUrl->shortenUrl($invalidUrl);
    }
}
