<?php

declare(strict_types=1);

namespace App\Infrastructure\Url\Message\Click;

use App\Application\Url\Provider\UrlProvider;
use App\Infrastructure\Url\Repository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ClickHandler
{
    public function __construct(
        private UrlProvider $urlProvider,
        private Repository $repository,
    ) {
    }

    public function __invoke(ClickMessage $message): void
    {
        $url = $this->urlProvider->loadById($message->getUrlId());

        if ($url)
        {
            $url->setClicks(
                $url->getClicks() + 1
            );

            $this->repository->save($url);
        }

        print_r("click" . " " . $message->getUrlId() . "\n");
    }
}
