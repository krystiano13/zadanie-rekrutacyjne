<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\SoftDeletableEntity;
use App\Domain\Enum\UrlTypeEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'urls')]
class Url extends BaseEntity
{
    use SoftDeletableEntity;

    #[ORM\Column(type: Types::STRING, length: 32, unique: true)]
    private string $code;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $url;

    #[ORM\Column(enumType: UrlTypeEnum::class)]
    private UrlTypeEnum $type;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $expiresAt = null;

    #[ORM\Column(type: Types::STRING, unique: true, nullable: true)]
    private ?string $alias = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $clicks = 0;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'urls')]
    private User $user;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getType(): UrlTypeEnum
    {
        return $this->type;
    }

    public function setType(UrlTypeEnum $type): void
    {
        $this->type = $type;
    }

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?\DateTimeImmutable $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): void
    {
        $this->alias = $alias;
    }

    public function getClicks(): int
    {
        return $this->clicks;
    }

    public function setClicks(int $clicks): void
    {
        $this->clicks = $clicks;
    }

    public function addClick(): void
    {
        ++$this->clicks;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
