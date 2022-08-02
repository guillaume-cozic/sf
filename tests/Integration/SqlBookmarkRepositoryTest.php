<?php

namespace App\Tests\Integration;

use App\Domain\Bookmark;
use App\Domain\BookmarkRepository;
use App\Domain\LinkInfo;
use App\Domain\Url;
use App\Infrastructure\Entity\BookmarkDb;
use App\Infrastructure\SqlBookmarkRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class SqlBookmarkRepositoryTest extends KernelTestCase
{
    /**
     * @var BookmarkRepository
     */
    private $bookmarkRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function setUp(): void
    {
        self::bootKernel([
            'debug'       => false,
        ]);
        $container = static::getContainer();
        $this->bookmarkRepository = $container->get(SqlBookmarkRepository::class);
        $this->entityManager = $container->get(ManagerRegistry::class)->getManager();
    }

    /**
     * @test
     */
    public function shouldSaveBookmark()
    {
        $id = Uuid::v4();
        $linkInfo = new LinkInfo(
            'youtube',
            'title',
            'author',
            '2022-05-04 00:00:00',
            1,
            2,
            'PT9M16S'
        );
        $bookmark = new Bookmark($id, new Url('http://url.com'), $linkInfo);

        self::assertNull($this->bookmarkRepository->get($id));

        $this->bookmarkRepository->save($bookmark);
        $bookmarkSaved = $this->bookmarkRepository->get($id);
        self::assertEquals($bookmark, $bookmarkSaved);

        $bookmarkDb = $this->entityManager->getRepository(BookmarkDb::class)->findOneBy(['uuid' => $id]);
        self::assertNotNull($bookmarkDb->getCreatedAt());
    }

    /**
     * @test
     */
    public function shouldDeleteBookmark()
    {
        $id = Uuid::v4();
        $linkInfo = new LinkInfo(
            'youtube',
            'title',
            'author',
            '2022-05-04 00:00:00',
            1,
            2,
            'PT9M16S'
        );
        $bookmark = new Bookmark($id, new Url('http://url.com'), $linkInfo);
        $this->bookmarkRepository->save($bookmark);

        self::assertNotNull($this->bookmarkRepository->get($id));
        $this->bookmarkRepository->delete($id);
        self::assertNull($this->bookmarkRepository->get($id));
    }
}