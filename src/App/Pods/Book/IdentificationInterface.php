<?php

namespace Jigius\LittleSweetPods\App\Pods\Book;

/**
 * Book's identification
 */
interface IdentificationInterface
{
	/**
	 * Returns book's id
	 * @return int
	 */
	public function id(): int;
}
