<?php

namespace Jigius\LittleSweetPods\Foundation\Persistence;

use Iterator;
use Jigius\LittleSweetPods\Illuminate\Persistence\Db\RequestInterface;

/**
 * Used for data persistence goals
 */
interface RepositoryInterface
{
	/**
	 * Fetches requested data
	 * @param RequestInterface $r
	 * @return Iterator
	 */
	public function fetched(RequestInterface $r): Iterator;

	/**
	 * Executes a request
	 * @param RequestInterface $r
	 * @return RepositoryInterface
	 */
	public function executed(RequestInterface $r): RepositoryInterface;
}
