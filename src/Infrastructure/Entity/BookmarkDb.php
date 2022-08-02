<?php

namespace App\Infrastructure\Entity;

use App\Domain\Bookmark;
use App\Domain\LinkInfo;
use App\Domain\Url;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bookmark")
 */
class BookmarkDb
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="guid")
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $provider;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $published_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $width;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $height;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    public function toDomain(): Bookmark
    {
        $linkInfo = new LinkInfo(
            $this->getProvider(),
            $this->getTitle(),
            $this->getAuthor(),
            $this->getPublishedDate() !== null ? $this->getPublishedDate()->format('Y-m-d H:i:s') : null,
            $this->getWidth(),
            $this->getHeight(),
            $this->getDuration()
        );
        return new Bookmark(
            $this->getUuid(),
            new Url($this->getUrl()),
            $linkInfo
        );
    }

    public function hydrate(Bookmark $bookmark): self
    {
        $bookmarkData = $bookmark->toArray();
        $this->uuid = $bookmarkData['id'];
        $this->url = $bookmarkData['url'];
        $this->provider = $bookmarkData['provider'];
        $this->title = $bookmarkData['title'];
        $this->author = $bookmarkData['author'];
        $this->width = $bookmarkData['width'];
        $this->height = $bookmarkData['height'];
        $this->duration = $bookmarkData['duration'];
        $this->published_date = $bookmarkData['published_date'] !== null ? (new \DateTime())->setTimestamp(strtotime($bookmarkData['published_date'])) : null;
        return $this;
    }

    public function toReadModel(): array
    {
        return [
            'id' => $this->uuid,
            'url' => $this->url,
            'provider' => $this->provider,
            'title' => $this->title,
            'author' => $this->author,
            'width' => $this->width,
            'height' => $this->height,
            'duration' => $this->duration,
            'created_at' => $this->getCreatedAt() !== null ? $this->getCreatedAt()->format('Y-m-d H:i:s') : null,
            'published_date' => $this->getPublishedDate() !== null ? $this->getPublishedDate()->format('Y-m-d H:i:s') : null
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(?string $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPublishedDate(): ?\DateTimeInterface
    {
        return $this->published_date;
    }

    public function setPublishedDate(?\DateTimeInterface $published_date): self
    {
        $this->published_date = $published_date;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
