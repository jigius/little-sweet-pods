<?php

namespace Jigius\LittleSweetPods\Illuminate\Persistence\Pdo;

use PDOStatement;

/**
 * Used for data persistence goals
 */
interface RepositoryInterface
{
	/**
	 * Executes a data request
	 * @param RequestInterface $r
	 * @return PDOStatement
	 */
	public function executed(RequestInterface $r): PDOStatement;
}
