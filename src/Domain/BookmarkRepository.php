<?php

namespace App\Domain;

interface BookmarkRepository
{
    public function get(string $id):?Bookmark;
    public function save(Bookmark $bookmark);
    public function delete(string $id);
    public function search():array;
}