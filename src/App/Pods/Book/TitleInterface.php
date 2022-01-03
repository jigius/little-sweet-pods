<?php

namespace Jigius\LittleSweetPods\App\Pods\Book;

/**
 * Book's title
 */
interface TitleInterface
{
	/**
	 * Returns book's title
	 * @return string
	 */
	public function title(): string;
}
