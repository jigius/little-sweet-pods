<?php

namespace Jigius\LittleSweetPods\App\Pods\Language\Persistence\Pdo\Request;

use Jigius\LittleSweetPods\Illuminate\Persistence\Pdo\RequestInterface;
use PDO;
use PDOStatement;

/**
 * Does the fetching data about one Language by its ID
 */
final class RqLanguageWithId implements RequestInterface
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
				"`languages`",
			"WHERE",
				"`language_id`=:id"
		];
		$stmt = $pdo->prepare(implode(" ", $sql));
		$stmt->execute([':id' => $this->id]);
		return $stmt;
	}
}
