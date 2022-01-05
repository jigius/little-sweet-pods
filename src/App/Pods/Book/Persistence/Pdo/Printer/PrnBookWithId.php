<?php

namespace Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo\Printer;

use DateTimeImmutable;
use DateTimeZone;
use Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo\EntBook;
use Jigius\LittleSweetPods\App\Pods\Language as Language;
use Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo;
use Jigius\LittleSweetPods\Illuminate\Persistence\Pdo\RepositoryInterface;
use DomainException;
use LogicException;
use Symfony\Component\Filesystem\Exception\InvalidArgumentException;

/**
 * Extracts (prints) book entity with specified ID from the persistence layer
 */
final class PrnBookWithId implements Pdo\PrinterEntityInterface
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
	 * @throws LogicException|DomainException|InvalidArgumentException
	 */
	public function finished(): Pdo\EntityInterface
	{
        if (!isset($this->i['id'])) {
            throw new InvalidArgumentException("`id` is not defined");
        }  elseif (!is_int($this->i['id'])) {
            throw new LogicException("type invalid");
        }
        if (!isset($this->i['blank'])) {
            $blank = new EntBook();
        } elseif (!$this->i['blank'] instanceof Pdo\EntityInterface) {
            throw new LogicException("type invalid");
        } else {
            $blank = $this->i['blank'];
        }
		$entities =
			$this
				->r
				->executed(
					new Pdo\Request\RqBookWithId($this->i['id'])
				);
		if ($entities->rowCount() === 0) {
			throw new DomainException("data not found", 404);
		}
		$i = $entities->fetch(\PDO::FETCH_ASSOC);
		$book = $blank->withId($this->i['id']);
		if (isset($i['title'])) {
			$book = $book->withTitle($i['title']);
		}
		if (isset($i['isbn'])) {
			$book = $book->withIsbn($i['isbn']);
		}
		if (isset($i['language_id'])) {
			$book = $book->withLanguage(
				(new Language\Persistence\Pdo\EntLazyLanguage(
					new Language\Persistence\Pdo\EntLanguage(),
					new Language\Persistence\Pdo\Printer\PrnLanguageWithId($this->r)
				))
					->withId($i['language_id'])
			);
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
