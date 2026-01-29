<?php

declare(strict_types=1);

namespace App\Web\Controller\Url;

use App\Application\Url\Provider\UrlProvider;
use App\Infrastructure\Url\Message\Click\ClickMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    #[Route(path: '/{shortCode}', name: 'api_redirect', methods: ['GET', 'HEAD'])]
    public function redirectUrl(string $shortCode, UrlProvider $provider): RedirectResponse
    {
        $url = $provider->loadByShortCode($shortCode);

        if (!$url) {
            throw new \InvalidArgumentException('URL not found');
        }

        $message = new ClickMessage($url->getId()->toString());
        $this->bus->dispatch($message);

        return $this->redirect($url->getUrl());
    }
}
