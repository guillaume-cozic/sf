<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Application\CreateBookmarkRequest;
use App\Application\CreateBookmarkUseCase;
use App\Domain\Bookmark;
use App\Domain\BookmarkRepository;
use App\Domain\Exception\InvalidState;
use App\Domain\Exception\LinkInfoNotRetrieved;
use App\Domain\LinkInfo;
use App\Domain\Url;
use App\Tests\Adapters\InMemoryBookmarkRepository;
use App\Tests\Adapters\InMemoryLinkInfoProvider;
use PHPUnit\Framework\TestCase;

class CreateBookmarkUseCaseTest extends TestCase
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
        $linkInfoProvider = new InMemoryLinkInfoProvider();
        $this->useCase = new CreateBookmarkUseCase(
            $this->bookmarkRepository,
            $linkInfoProvider
        );
    }

    /**
     * @test
     */
    public function shouldCreateABookmark()
    {
        $url = 'http://url-valide.com';

        $request = new CreateBookmarkRequest($url);
        $id = $this->useCase->execute($request);

        $bookmarkSaved = $this->bookmarkRepository->get($id);

        $linkInfo = new LinkInfo(
            'youtube',
            'title',
            'author',
            '2022-05-04',
            '10',
            '20',
            '11'
        );
        $bookmarkExpected = new Bookmark($id, new Url($url), $linkInfo);
        self::assertEquals($bookmarkExpected, $bookmarkSaved);
    }

    /**
     * @test
     */
    public function shouldNotCreateABookmarkWhenUrlInvalid()
    {
        $url = 'url-non-valide.com';
        $request = new CreateBookmarkRequest($url);

        self::expectExceptionMessage('INVALID_URL');
        self::expectException(InvalidState::class);
        $this->useCase->execute($request);
    }

    /**
     * @test
     */
    public function shouldNotCreateABookmarkWhenLinkInfoCantBeRetrieved()
    {
        $url = 'http://url-with-timeout.com';
        $request = new CreateBookmarkRequest($url);

        self::expectException(LinkInfoNotRetrieved::class);
        $this->useCase->execute($request);
    }
}