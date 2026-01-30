<?php

declare(strict_types=1);

namespace App\Tests\Unit\Symfony\Security;

use App\Application\Symfony\Security\JwtAuthenticator;
use App\Application\User\Provider\UserProvider;
use App\Domain\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class JwtAuthenticatorTest extends TestCase
{
    private JwtAuthenticator $jwtAuthenticator;
    private JWTTokenManagerInterface $jwtTokenManager;
    private UserProvider $userProvider;

    public function setUp(): void
    {
        parent::setUp();

        $this->jwtTokenManager = $this->createMock(JWTTokenManagerInterface::class);
        $this->userProvider = $this->createMock(UserProvider::class);

        $this->jwtAuthenticator = new JwtAuthenticator(
            $this->jwtTokenManager,
            $this->userProvider,
        );
    }

    public function testAuthenticate(): void
    {
        $request = new Request();
        $mockUser = new User();
        $token = $this->jwtTokenManager->create($mockUser);
        $request->headers->set('Authorization', 'Bearer '.$token);

        $payload = ['username' => $mockUser->getId()->toString()];

        $this->jwtTokenManager
            ->expects($this->once())
            ->method('parse')
            ->with($token)
            ->willReturn($payload);

        $passport = $this->jwtAuthenticator->authenticate($request);

        $this->assertInstanceOf(SelfValidatingPassport::class, $passport);

        $badge = $passport->getBadge(UserBadge::class);

        $this->assertInstanceOf(UserBadge::class, $badge);
    }

    public function testThrowsErrorOnInvalidToken(): void
    {
        $request = new Request();
        $request->headers->set('Authorization', 'Bearer 123');

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Invalid token');

        $this->jwtAuthenticator->authenticate($request);
    }

    public function testAuthenticationFailureReturns401(): void
    {
        $request = new Request();
        $exception = new AuthenticationException();

        $result = $this->jwtAuthenticator->onAuthenticationFailure($request, $exception);

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(401, $result->getStatusCode());
    }
}
