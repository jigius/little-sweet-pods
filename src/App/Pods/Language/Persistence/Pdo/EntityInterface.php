<?php

namespace Jigius\LittleSweetPods\App\Pods\Language\Persistence\Pdo;

use Jigius\LittleSweetPods\App\Pods\Language as Vanilla;
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
	 * @inheritDoc
	 * @return EntityInterface
	 */
	public function withId(int $id): EntityInterface;

	/**
	 * @inheritDoc
	 * @return EntityInterface
	 */
	public function withName(string $name): EntityInterface;
}
