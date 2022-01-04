<?php

namespace Jigius\LittleSweetPods\App\Pods\Language\Persistence\Pdo\Printer;

use DateTimeImmutable;
use DateTimeZone;
use Jigius\LittleSweetPods\App\Pods\Language\Persistence\Pdo;
use Jigius\LittleSweetPods\Illuminate\Persistence\Pdo\RepositoryInterface;
use DomainException;
use LogicException;

/**
 * Class PrnLanguageWithId
 */
final class PrnLanguageWithId implements Pdo\PrinterEntityInterface
{
	/**
	 * @var RepositoryInterface
	 */
	private RepositoryInterface $r;
	/**
	 * @var array
	 */
	private array $i;

	/**
	 * Cntr
	 */
	public function __construct(RepositoryInterface $r)
	{
		$this->r = $r;
		$this->i = [];
	}

	/**
	 * @inheritDoc
	 * @throws LogicException|DomainException
	 */
	public function finished(): Pdo\EntityInterface
	{
		if (!isset($this->i['blank'])) {
			throw new LogicException("blank is not defined");
		}
		if (!$this->i['blank'] instanceof Pdo\EntityInterface) {
			throw new LogicException("type invalid");
		}
		$entities =
			$this
				->r
				->executed(
					new Pdo\Request\RqLanguageWithId($this->i['blank']->id())
				);
		if ($entities->rowCount() === 0) {
			throw new DomainException("data not found", 404);
		}
		$i = $entities->fetch(\PDO::FETCH_ASSOC);
		$book = $this->i['blank'];
		if (isset($i['name'])) {
			$book = $book->withName($i['name']);
		}
		foreach(['published', 'created', 'changed'] as $field) {
			if (isset($i[$field])) {
				$book =
					$book
						->withPublished(
							DateTimeImmutable::createFromFormat(
								"Y-m-d H:i:s",
								$i[$field],
								new DateTimeZone("UTC")
							)
						);

			}
		}
		return $book->withPersisted(true);
	}

	/**
	 * @inheritDoc
	 */
	public function with(string $key, $val): self
	{
		$that = $this->blueprinted();
		$that->i[$key] = $val;
		return $that;
	}

	/**
	 * Clones the instance
	 * @return $this
	 */
	public function blueprinted(): self
	{
		$that = new self($this->r);
		$that->i = $this->i;
		return $that;
	}
}
