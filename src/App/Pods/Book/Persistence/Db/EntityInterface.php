<?php

namespace Jigius\LittleSweetPods\App\Pods\Book\Persistence\Db;

use Jigius\LittleSweetPods\App\Pods\Book as Vanilla;
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
}
