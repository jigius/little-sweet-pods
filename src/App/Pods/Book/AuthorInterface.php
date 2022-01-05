<?php

namespace Jigius\LittleSweetPods\App\Pods\Book;

use Jigius\LittleSweetPods\App\Pods\Author;

/**
 * Book's author(s)
 */
interface AuthorInterface
{
    /**
     * Returns book's author(s)
     * @return Author\IteratorInterface
     */
	public function author(): Author\IteratorInterface;
}
