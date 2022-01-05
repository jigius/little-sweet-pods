<?php

namespace Jigius\LittleSweetPods\App\Pods\Language\Persistence\Pdo;

use DateTimeInterface;
use Jigius\LittleSweetPods\Foundation as F;
use LogicException;

/**
 * Language-entity with capable of lazy loading from the persistence layer into Db
 */
final class EntLazyLanguage implements EntityInterface
{
	/**
	 * @var PrinterEntityInterface
	 */
	private PrinterEntityInterface $p;
	/**
	 * @var EntityInterface
	 */
	private EntityInterface $original;
	/**
	 * Signs if the entity has been loaded from persisted layer or not
	 * @var false
	 */
	private bool $loaded;

	/**
	 * Cntr
	 * @param EntityInterface $entity
	 * @param PrinterEntityInterface $p
	 */
	public function __construct(EntityInterface $entity, PrinterEntityInterface $p)
	{
		$this->original = $entity;
		$this->p = $p;
		$this->loaded = false;
	}

	/**
	 * @inheritDoc
	 */
	public function withPersisted(bool $flag): EntityInterface
	{
		if (!$this->loaded) {
			return $this->loaded()->withPersisted($flag);
		}
		return $this->original->withPersisted($flag);
	}

	/**
	 * @inheritDoc
	 */
	public function withId(int $id): self
	{
		$that = $this->blueprinted();
		$that->original = $this->original->withId($id);
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function withName(string $name): EntityInterface
	{
		if (!$this->loaded) {
			return $this->loaded()->withName($name);
		}
		return $this->original->withName($name);
	}

    /**
     * @inheritDoc
     */
    public function withLocale(string $locale): EntityInterface
    {
        if (!$this->loaded) {
            return $this->loaded()->withLocale($locale);
        }
        return $this->original->withLocale($locale);
    }

	/**
	 * @inheritDoc
	 */
	public function withCreated(DateTimeInterface $dt): EntityInterface
	{
		if (!$this->loaded) {
			return $this->loaded()->withCreated($dt);
		}
		return $this->original->withCreated($dt);
	}

	/**
	 * @inheritDoc
	 */
	public function withChanged(DateTimeInterface $dt): EntityInterface
	{
		if (!$this->loaded) {
			return $this->loaded()->withChanged($dt);
		}
		return $this->original->withChanged($dt);
	}

	/**
	 * @inheritDoc
	 */
	public function id(): int
	{
		return $this->original->id();
	}

	/**
	 * @inheritDoc
	 */
	public function name(): string
	{
		if (!$this->loaded) {
			return $this->loaded()->name();
		}
		return $this->original->name();
	}

    /**
     * @inheritDoc
     */
    public function locale(): string
    {
        if (!$this->loaded) {
            return $this->loaded()->locale();
        }
        return $this->original->locale();
    }

	/**
	 * @inheritDoc
	 */
	public function printed(F\PrinterInterface $p)
	{
		if (!$this->loaded) {
			return $this->loaded()->printed($p);
		}
		return $this->original->printed($p);
	}

	/**
	 * Clones the instance
	 * @return EntLazyLanguage
	 */
	public function blueprinted(): self
	{
		$that = new self($this->original, $this->p);
		$that->loaded = $this->loaded;
		return $that;
	}

	/**
	 * Loads data for the entity from the persistence layer
	 * @return EntLazyLanguage
	 * @throws LogicException
	 */
	private function loaded(): self
	{
		if ($this->loaded) {
			throw new LogicException("already loaded");
		}
		$that = $this->blueprinted();
		$that
			->original =
				$this
					->p
					->with('id', $this->id())
					->finished();
		$that->loaded = true;
		return $that;
	}
}
