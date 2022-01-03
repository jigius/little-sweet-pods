<?php

namespace Jigius\LittleSweetPods\Foundation\Persistence;

use Jigius\LittleSweetPods\Foundation\MediaInterface;

/**
 * Used for defines a request into Repository
 */
interface RequestInterface extends MediaInterface
{
	/**
	 * Executes the request
	 * @param mixed ...$args
	 * @return RequestInterface
	 */
	public function executed(...$args): RequestInterface;
}
