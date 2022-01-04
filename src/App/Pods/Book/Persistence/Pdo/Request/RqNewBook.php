<?php

namespace Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo\Request;

use DateTimeInterface;
use DomainException;
use Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo\EntityInterface;
use Jigius\LittleSweetPods\App\Pods\Language;
use Jigius\LittleSweetPods\Illuminate\Persistence\Pdo\RequestInterface;
use Jigius\LittleSweetPods\Illuminate\PrnArray;
use PDO;
use PDOStatement;

/**
 * Appends a data about new Book
 */
final class RqNewBook implements RequestInterface
{
	/**
	 * @var EntityInterface
	 */
	private EntityInterface $book;

	/**
	 * Cntr
	 * @param EntityInterface $book
	 */
	public function __construct(EntityInterface $book)
	{
		$this->book = $book;
	}

	/**
	 * @inheritDoc
	 * @throws DomainException
	 */
	public function executed(PDO $pdo): PDOStatement
	{
		$i =
			$this
				->book
				->printed(
					new PrnArray(
						['id',	'title', 'isbn', 'language', 'published', 'created', 'changed']
					)
				);
		if (!isset($i['id'])) {
			throw new DomainException("`id` is mandatory");
		}
		$d = [];
		if (!is_int($i['id'])) {
			throw new DomainException("`id` type is invalid");
		} else {
			$d['book_id'] = $i['id'];
		}
		if (isset($i['title'])) {
			if (!is_string($i['title'])) {
				throw new DomainException("`title` type is invalid");
			} else {
				$d['title'] = $i['title'];
			}
		}
		if (isset($i['isbn'])) {
			if (!is_string($i['isbn'])) {
				throw new DomainException("`isbn` type is invalid");
			} else {
				$d['isbn'] = $i['isbn'];
			}
		}
		if (isset($i['language'])) {
			if (!$i['language'] instanceof Language\EntityInterface) {
				throw new DomainException("`language` type is invalid");
			} else {
				$d['language_id'] = $i['language']->id();
			}
		}
		if (isset($i['published'])) {
			if (!$i['published'] instanceof DateTimeInterface) {
				throw new DomainException("`published` type is invalid");
			} else {
				$d['published'] = $i['published']->format("Y-m-d H:i:s");
			}
		}
		if (isset($i['created'])) {
			if (!$i['created'] instanceof DateTimeInterface) {
				throw new DomainException("`created` type is invalid");
			} else {
				$d['created'] = $i['creted']->format("Y-m-d H:i:s");
			}
		}
		if (isset($i['changed'])) {
			if (!$i['changed'] instanceof DateTimeInterface) {
				throw new DomainException("`changed` type is invalid");
			} else {
				$d['changed'] = $i['changed']->format("Y-m-d H:i:s");
			}
		}
		$stmt =
			$pdo
				->prepare(
					implode(
						" ",
						[
							"INSERT INTO `books`",
								"(",
									implode(
										",",
										array_map(
											function (string $itm): string {
												return "`$itm`";
											},
											array_keys($d)

										)
									),
								")",
							"VALUES",
								"(",
									implode(
										",",
										array_map(
											function (string $itm): string {
												return ":$itm";
											},
											array_keys($d)
										)
									),
								")"
						]
					)
				);
		$values = [];
		array_walk(
			$d,
			function ($val, $key) use (&$values) {
				$values[":$key"] = $val;
			}
		);
		$stmt->execute($values);
		return $stmt;
	}
}
