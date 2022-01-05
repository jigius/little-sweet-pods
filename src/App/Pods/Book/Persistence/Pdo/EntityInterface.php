<?php

namespace Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo;

use Jigius\LittleSweetPods\App\Pods\Book as Vanilla;
use Jigius\LittleSweetPods\App\Pods\Language;
use Jigius\LittleSweetPods\App\Pods\Author;
use DateTimeInterface;

/**
 * Extends vanilla entity with data are value for db persistence layer
 */
interface EntityInterface extends Vanilla\EntityInterface
{
	/**
	 * @param DateTimeInterface $dt
	 * @return EntityInterface
	 */
	public function withCreated(DateTimeInterface $dt): EntityInterface;

	/**
	 * @param DateTimeInterface $dt
	 * @return EntityInterface
	 */
	public function withChanged(DateTimeInterface $dt): EntityInterface;

	/**
	 * @param bool $flag
	 * @return EntityInterface
	 */
	public function withPersisted(bool $flag): EntityInterface;

    /**
     * Defines book's id
     * @param int $id
     * @return EntityInterface
     */
	public function withId(int $id): EntityInterface;

    /**
     * Defines book's isbn
     * @param string $isbn
     * @return EntityInterface
     */
	public function withIsbn(string $isbn): EntityInterface;

    /**
     * Defines book's lang
     * @param Language\EntityInterface $lang
     * @return EntityInterface
     */
	public function withLanguage(Language\EntityInterface $lang): EntityInterface;

    /**
     * Defines when book was published
     * @param DateTimeInterface $pub
     * @return EntityInterface
     */
	public function withPublished(DateTimeInterface $pub): EntityInterface;

    /**
     * Defines book's title
     * @param string $title
     * @return EntityInterface
     */
	public function withTitle(string $title): EntityInterface;

    /**
     * Defines book's author(s)
     * @param Author\Persistence\Pdo\IteratorInterface $author
     * @return EntityInterface
     */
    public function withAuthor(Author\Persistence\Pdo\IteratorInterface $author): EntityInterface;
}
