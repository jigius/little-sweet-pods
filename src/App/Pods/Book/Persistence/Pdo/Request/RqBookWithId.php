<?php

namespace Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo\Request;

use Jigius\LittleSweetPods\Illuminate\Persistence\Pdo\RequestInterface;
use PDO;
use PDOStatement;

/**
 * Does the fetching data about one Book by its ID
 */
final class RqBookWithId implements RequestInterface
{
	/**
	 * @var int
	 */
	private int $id;

	/**
	 * Cntr
	 * @param int $id
	 */
	public function __construct(int $id)
	{
		$this->id = $id;
	}

	/**
	 * @inheritDoc
	 */
	public function executed(PDO $pdo): PDOStatement
	{
		$sql = [
			"SELECT",
				"*",
			"FROM",
				"`book`",
			"WHERE",
				"`book_id`=:id"
		];
		$stmt = $pdo->prepare(implode(" ", $sql));
		$stmt->execute([':id' => $this->id]);
		return $stmt;
	}
}
