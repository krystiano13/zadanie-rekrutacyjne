<?php

declare(strict_types=1);

namespace App\Web\Controller\Url;

use App\Application\Url\Provider\UrlProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    #[Route(path: '/{shortCode}', name: 'api_redirect', methods: ['GET', 'HEAD'])]
    public function redirectUrl(string $shortCode, UrlProvider $provider): RedirectResponse
    {
        $url = $provider->loadByShortCode($shortCode);

        if (!$url) {
            throw new \InvalidArgumentException('URL not found');
        }

        return $this->redirect($url->getUrl());
    }
}
