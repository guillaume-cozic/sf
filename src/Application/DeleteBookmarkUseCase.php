<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\BookmarkRepository;
use App\Domain\Exception\BookmarkNotFound;

final class DeleteBookmarkUseCase
{
    /**
     * @var BookmarkRepository
     */
    private $bookmarkRepository;

    public function __construct(BookmarkRepository $bookmarkRepository)
    {
        $this->bookmarkRepository = $bookmarkRepository;
    }

    public function execute(DeleteBookmarkRequest $request)
    {
        $bookmark = $this->bookmarkRepository->get($request->getId());
        if($bookmark === null){
            throw new BookmarkNotFound();
        }
        $this->bookmarkRepository->delete($request->getId());
    }
}