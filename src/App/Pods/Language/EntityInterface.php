<?php

namespace Jigius\LittleSweetPods\App\Pods\Language;

use Jigius\LittleSweetPods\Foundation\MediaInterface;

/**
 * Language entity
 */
interface EntityInterface extends
	MediaInterface,
	IdentificationInterface,
	NameInterface
{
	/**
	 * Defines language's id
	 * @param int $id
	 * @return EntityInterface
	 */
	public function withId(int $id): EntityInterface;

	/**
	 * Defines language's title
	 * @param string $title
	 * @return EntityInterface
	 */
	public function withName(string $name): EntityInterface;
}
