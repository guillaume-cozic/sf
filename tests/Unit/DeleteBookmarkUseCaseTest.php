<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Application\CreateBookmarkUseCase;
use App\Application\DeleteBookmarkRequest;
use App\Application\DeleteBookmarkUseCase;
use App\Domain\Bookmark;
use App\Domain\BookmarkRepository;
use App\Domain\Exception\BookmarkNotFound;
use App\Domain\LinkInfo;
use App\Domain\Url;
use App\Tests\Adapters\InMemoryBookmarkRepository;
use PHPUnit\Framework\TestCase;

class DeleteBookmarkUseCaseTest extends TestCase
{
    /**
     * @var CreateBookmarkUseCase
     */
    private $useCase;

    /**
     * @var BookmarkRepository
     */
    private $bookmarkRepository;

    public function setUp(): void
    {
        $this->bookmarkRepository = new InMemoryBookmarkRepository();
        $this->useCase = new DeleteBookmarkUseCase($this->bookmarkRepository);
    }

    /**
     * @test
     */
    public function shouldNotDeleteBookmarkIfBookmarkDoesNotExists()
    {
        $id = 'unknownBookmarkId';
        $request = new DeleteBookmarkRequest($id);

        self::expectException(BookmarkNotFound::class);
        $this->useCase->execute($request);
    }

    /**
     * @test
     */
    public function shouldDeleteBookmark()
    {
        $id = 'bookmarkId';
        $url = 'http://url-valide.com';
        $request = new DeleteBookmarkRequest($id);

        $linkInfo = new LinkInfo(
            'youtube',
            'title',
            'author',
            '2022-05-04',
            null,
            null,
            null
        );
        $bookmark = new Bookmark($id, new Url($url), $linkInfo);
        $this->bookmarkRepository->save($bookmark);

        self::assertNotEmpty($this->bookmarkRepository->get($id));

        $this->useCase->execute($request);

        self::assertEmpty($this->bookmarkRepository->get($id));
    }
}