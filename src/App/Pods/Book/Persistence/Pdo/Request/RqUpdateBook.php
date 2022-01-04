<?php

namespace Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo\Request;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use DomainException;
use Exception;
use Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo\EntityInterface;
use Jigius\LittleSweetPods\App\Pods\Language;
use Jigius\LittleSweetPods\Illuminate\Persistence\Pdo\RequestInterface;
use Jigius\LittleSweetPods\Illuminate\PrnArray;
use PDO;
use PDOStatement;

/**
 * Updates data about a Book with persistence layer
 */
final class RqUpdateBook implements RequestInterface
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
	 * @throws Exception|DomainException
	 */
	public function executed(PDO $pdo): PDOStatement
	{
		$i =
			$this
				->book
				->printed(
					new PrnArray(
						['id',	'title', 'isbn', 'language', 'published', 'changed']
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
		if (!isset($i['changed'])) {
			$d['changed'] =
				(new DateTimeImmutable(
					"now",
					new DateTimeZone("UTC")
				))
					->format("Y-m-d H:i:s");
		} elseif (!$i['changed'] instanceof DateTimeInterface) {
			throw new DomainException("`changed` type is invalid");
		} else {
			$d['changed'] = $i['changed']->format("Y-m-d H:i:s");
		}
		$stmt =
			$pdo
				->prepare(
					implode(
						" ",
						[
							"UPDATE `books`",
							"SET",
								implode(
									",",
									array_map(
										function (string $field): string {
											return "`$field`=:$field";
										},
										array_filter(
											array_keys($d),
											function ($field) {
												return $field !== "book_id";
											}
										)
									)
								),
							"WHERE book_id=:id"
						]
					)
				);
		$values = [];
		array_walk(
			$d,
			function ($val, $field) use (&$values) {
				$values[":$field"] = $val;
			}
		);
		$stmt->execute($values);
		return $stmt;
	}
}
