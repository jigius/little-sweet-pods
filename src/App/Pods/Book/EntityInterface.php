<?php

namespace Jigius\LittleSweetPods\App\Pods\Book;

use Jigius\LittleSweetPods\App\Pods\Language;
use DateTimeInterface;
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
	PublishedInterface
{
	/**
	 * Defines book's id
	 * @param int $id
	 * @return EntityInterface
	 */
	public function withId(int $id): EntityInterface;

	/**
	 * Defines book's title
	 * @param string $title
	 * @return EntityInterface
	 */
	public function withTitle(string $title): EntityInterface;

	/**
	 *  Defines book's ISBN
	 * @param string $isbn
	 * @return EntityInterface
	 */
	public function withIsbn(string $isbn): EntityInterface;

	/**
	 * Defines when book was published
	 * @param DateTimeInterface $pub
	 * @return EntityInterface
	 */
	public function withPublished(DateTimeInterface $pub): EntityInterface;

	/**
	 * Defines book's language
	 * @param Language\LanguageInterface $lang
	 * @return EntityInterface
	 */
	public function withLanguage(Language\LanguageInterface $lang): EntityInterface;
}
