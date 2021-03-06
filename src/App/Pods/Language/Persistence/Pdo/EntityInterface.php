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
     * Defines language's id
     * @param int $id
     * @return EntityInterface
     */
    public function withId(int $id): EntityInterface;

    /**
     * Defines language's name
     * @param string $name
     * @return EntityInterface
     */
    public function withName(string $name): EntityInterface;

    /**
     * Defines language's locale
     * @param string $locale
     * @return EntityInterface
     */
    public function withLocale(string $locale): EntityInterface;
}
