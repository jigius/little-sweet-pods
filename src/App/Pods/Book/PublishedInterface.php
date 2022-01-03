<?php

namespace Jigius\LittleSweetPods\App\Pods\Book;

use DateTimeInterface;

/**
 *  When book was published
 */
interface PublishedInterface
{
	/**
	 * Returns a datetime when book was published
	 * @return DateTimeInterface
	 */
	public function published(): DateTimeInterface;
}
