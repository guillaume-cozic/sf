<?php

declare(strict_types=1);

namespace App\Tests\Adapters;

use App\Domain\Bookmark;
use App\Domain\BookmarkRepository;

class InMemoryBookmarkRepository implements BookmarkRepository
{
    private $bookmarks = [];

    public function get(string $id): ?Bookmark
    {
        return isset($this->bookmarks[$id]) ? clone $this->bookmarks[$id] : null;
    }

    public function save(Bookmark $bookmark)
    {
        $this->bookmarks[$bookmark->getId()] = $bookmark;
    }

    public function delete(string $id)
    {
        unset($this->bookmarks[$id]);
    }

    public function search(): array
    {
        // Pas besoin dans le cadre des tests
    }

}