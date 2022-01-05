<?php

namespace Jigius\LittleSweetPods\App\Pods\Book;

use Jigius\LittleSweetPods\Foundation\MediaInterface;

/**
 * Book entity
 */
interface EntityInterface extends
	MediaInterface,
	IdentificationInterface,
	TitleInterface,
	IsbnInterface,
	LanguageInterface,
	PublishedInterface,
    AuthorInterface
{
}
