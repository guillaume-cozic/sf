<?php

namespace App\Application;

use App\Domain\BookmarkRepository;

class GetBookmarksQuery
{
    private $bookmarkRepository;

    public function __construct(BookmarkRepository $bookmarkRepository)
    {
        $this->bookmarkRepository = $bookmarkRepository;
    }

    /**
     * @todo impl les diff filtres...
     * tester le code
     */
    public function execute():array
    {
        $bookmarks = $this->bookmarkRepository->search();
        foreach($bookmarks as $key => $bookmark){
            $linkDelete = 'http://localhost:8000/bookmarks/'.$bookmark['id'];
            $bookmarks[$key]['action']['delete'] = "curl --location --request DELETE '$linkDelete'";
        }
        return $bookmarks;
    }
}