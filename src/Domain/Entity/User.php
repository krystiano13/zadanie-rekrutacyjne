<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User extends BaseEntity implements UserInterface
{
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $expiresAt;

    /**
     * @var Collection<int, Url>
     */
    #[ORM\OneToMany(targetEntity: Url::class, mappedBy: 'user')]
    private Collection $urls;

    public function __construct()
    {
        parent::__construct();
        $this->urls = new ArrayCollection();
    }

    public function getExpiresAt(): \DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTimeImmutable $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return Collection<int, Url>
     */
    public function getUrls(): Collection
    {
        return $this->urls;
    }

    public function addUrl(Url $url): void
    {
        if (!$this->urls->contains($url)) {
            $this->urls->add($url);
        }
    }

    public function removeUrl(Url $url): void
    {
        if ($this->urls->contains($url)) {
            $this->urls->removeElement($url);
        }
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getUserIdentifier(): string
    {
        return $this->getId()->toString();
    }
}
