<?php

declare(strict_types=1);

namespace App\Application\Url\Controller;

use App\Application\Url\DTO\CreateUrlRequestDTO;
use App\Application\Url\Handler\Create;
use App\Application\Url\Provider\UrlProvider;
use App\Application\Url\ShortUrl;
use App\Domain\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    #[Route(path: '/api/urls', name: 'api_urls_index', methods: ['GET', 'HEAD'])]
    public function index(UrlProvider $provider): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();

        $urls = $provider->loadByUser($user);

        return $this->json([
            'urls' => $urls,
        ], 200);
    }

    #[Route(path: '/api/urls', name: 'api_urls_create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload]
        CreateUrlRequestDTO $dto,
        Create $createHandler,
        ShortUrl $shortUrl
    ): JsonResponse {
        try {
            $shortenedUrl = $shortUrl->shortenUrl($dto->url);
            $createHandler->handle($dto, $shortenedUrl);

            return $this->json([
                'url' => $shortenedUrl,
            ], 200);
        } catch (UnprocessableEntityHttpException $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    #[Route(path: '/api/public', name: 'api_public', methods: ['GET', 'HEAD'])]
    public function getPublic(UrlProvider $provider): JsonResponse
    {
        $urls = $provider->loadAllPublic();

        return $this->json([
            'urls' => $urls,
        ], 200);
    }
}
