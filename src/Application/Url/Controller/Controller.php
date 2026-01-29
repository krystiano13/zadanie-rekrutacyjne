<?php

declare(strict_types=1);

namespace App\Application\Url\Controller;

use App\Application\Url\Provider\UrlProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    #[Route(path: '/api/public', name: 'api_public', methods: ['GET', 'HEAD'])]
    public function getPublic(UrlProvider $provider): JsonResponse
    {
        $urls = $provider->loadAllPublic();

        return $this->json([
            'urls' => $urls,
        ], 200);
    }
}
