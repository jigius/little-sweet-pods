<?php

namespace Jigius\LittleSweetPods\Illuminate\Persistence\Pdo;

use PDO;
use PDOStatement;

/**
 * Defines a data request for  interacting with Repository
 */
interface RequestInterface
{
	/**
	 * Executes a request
	 * @param PDO $pdo
	 * @return PDOStatement
	 */
	public function executed(PDO $pdo): PDOStatement;
}
