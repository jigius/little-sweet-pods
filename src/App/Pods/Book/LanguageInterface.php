<?php

namespace Jigius\LittleSweetPods\App\Pods\Book;

use Jigius\LittleSweetPods\App\Pods\Language;

/**
 * Book's language
 */
interface LanguageInterface
{
	/**
	 * Returns book's language
	 * @return Language\EntityInterface
	 */
	public function language(): Language\EntityInterface;
}
