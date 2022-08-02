<?php

namespace App\Infrastructure;

use App\Domain\Bookmark;
use App\Domain\BookmarkRepository;
use App\Infrastructure\Entity\BookmarkDb;
use Doctrine\Persistence\ManagerRegistry;

class SqlBookmarkRepository implements BookmarkRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->entityManager = $doctrine->getManager();
    }

    public function get(string $id): ?Bookmark
    {
        $bookmarkDb = $this->entityManager->getRepository(BookmarkDb::class)->findOneBy(['uuid' => $id]);
        if(!isset($bookmarkDb)){
            return null;
        }
        return $bookmarkDb->toDomain();
    }

    public function save(Bookmark $bookmark)
    {
        $bookmarkDb = new BookmarkDb();
        $bookmarkDb->hydrate($bookmark);

        $bookmarkDb->setCreatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($bookmarkDb);
        $this->entityManager->flush();
    }

    public function delete(string $id)
    {
        $bookmarkDb = $this->entityManager->getRepository(BookmarkDb::class)->findOneBy(['uuid' => $id]);
        $this->entityManager->remove($bookmarkDb);
        $this->entityManager->flush();
    }

    /**
     * @todo je priviligie le fait d'avoir un repository reservée à la lecture
     * ici par rapidité je l'ai mis dans le même repo
     */
    public function search():array
    {
        $bookmarks = $this->entityManager->getRepository(BookmarkDb::class)->findAll();
        return array_map(function (BookmarkDb $bookmarkDb){
            return $bookmarkDb->toReadModel();
        }, $bookmarks);
    }
}