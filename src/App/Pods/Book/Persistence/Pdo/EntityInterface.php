<?php

namespace Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo;

use Jigius\LittleSweetPods\App\Pods\Book as Vanilla;
use DateTimeInterface;
use Jigius\LittleSweetPods\App\Pods\Language;

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
	 * @inheritDoc
	 * @return EntityInterface
	 */
	public function withId(int $id): EntityInterface;

	/**
	 * @inheritDoc
	 * @return EntityInterface
	 */
	public function withIsbn(string $isbn): EntityInterface;

	/**
	 * @inheritDoc
	 * @return EntityInterface
	 */
	public function withLanguage(Language\EntityInterface $lang): EntityInterface;

	/**
	 * @inheritDoc
	 * @return EntityInterface
	 */
	public function withPublished(DateTimeInterface $pub): EntityInterface;

	/**
	 * @inheritDoc
	 * @return EntityInterface
	 */
	public function withTitle(string $title): EntityInterface;
}
