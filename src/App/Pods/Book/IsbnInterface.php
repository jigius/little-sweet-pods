<?php

namespace Jigius\LittleSweetPods\App\Pods\Book;

/**
 * Book's ISBN
 */
interface IsbnInterface
{
	/**
	 * Returns book's ISBN
	 * @return string
	 */
	public function isbn(): string;
}
