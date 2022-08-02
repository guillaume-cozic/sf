<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Bookmark;
use App\Domain\BookmarkRepository;
use App\Domain\Exception\InvalidState;
use App\Domain\LinkInfoProvider;
use App\Domain\Url;
use Symfony\Component\Uid\Uuid;

class CreateBookmarkUseCase
{
    /**
     * @var BookmarkRepository
     */
    private $bookmarkRepository;

    /**
     * @var LinkInfoProvider
     */
    private $linkInfoProvider;

    public function __construct(
        BookmarkRepository $bookmarkRepository,
        LinkInfoProvider $linkInfoProvider
    )
    {
        $this->bookmarkRepository = $bookmarkRepository;
        $this->linkInfoProvider = $linkInfoProvider;
    }

    /**
     * @throws InvalidState
     */
    public function execute(CreateBookmarkRequest $request)
    {
        $url = new Url($request->getUrl());

        $linkInfo = $this->linkInfoProvider->get($url->toString());

        $bookmark = new Bookmark($id = (string)Uuid::v4(), $url, $linkInfo);
        $this->bookmarkRepository->save($bookmark);
        return $id;
    }
}