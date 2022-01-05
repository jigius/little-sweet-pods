<?php

namespace Jigius\LittleSweetPods\App\Pods\Language\Persistence\Pdo\Printer;

use DateTimeImmutable;
use DateTimeZone;
use Jigius\LittleSweetPods\App\Pods\Language\Persistence\Pdo;
use Jigius\LittleSweetPods\Illuminate\Persistence\Pdo\RepositoryInterface;
use DomainException;
use LogicException;
use Symfony\Component\Filesystem\Exception\InvalidArgumentException;

/**
 * Prints out a language entity have being fetched from the persistence layer by its ID
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
			$blank = new Pdo\EntLanguage();
		} elseif (!$this->i['blank'] instanceof Pdo\EntityInterface) {
			throw new LogicException("type invalid");
		} else {
            $blank = $this->i['blank'];
        }
		$entities =
			$this
				->r
				->executed(
					new Pdo\Request\RqLanguageWithId($this->i['id'])
				);
		if ($entities->rowCount() === 0) {
			throw new DomainException("data not found", 404);
		}
		$i = $entities->fetch(\PDO::FETCH_ASSOC);
        $language = $blank->withId($this->i['id']);
		if (isset($i['name'])) {
			$language = $language->withName($i['name']);
		}
        if (isset($i['locale'])) {
            $language = $language->withLocale($i['locale']);
        }
		foreach(['created', 'changed'] as $field) {
			if (isset($i[$field])) {
				$language =
					$language
						->withPublished(
							DateTimeImmutable::createFromFormat(
								"Y-m-d H:i:s",
								$i[$field],
								new DateTimeZone("UTC")
							)
						);

			}
		}
		return $language->withPersisted(true);
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
