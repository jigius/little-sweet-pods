<?php

namespace Jigius\LittleSweetPods\App\Pods\Language\Persistence\Pdo;

use DateTimeInterface;
use Jigius\LittleSweetPods\Foundation as F;
use LogicException;
use DomainException;

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
	 * Signs if the entity has been loaded from the persistence layer or not
	 * @var bool
	 */
	private bool $loaded;
    /**
     * Defines if the entity has to be loaded before it will be printed
     * @var bool
     */
    private bool $autoload;

    /**
     * Cntr
     * @param EntityInterface $entity
     * @param PrinterEntityInterface $p
     * @param bool $loadBeforePrinted Defines if the entity has to be loaded before it will be printed
     */
	public function __construct(EntityInterface $entity, PrinterEntityInterface $p, bool $loadBeforePrinted = false)
    {
		$this->original = $entity;
		$this->p = $p;
		$this->loaded = false;
        $this->autoload = $loadBeforePrinted;
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
		$that = $this->blueprinted();
		$that->original = $this->original->withName($name);
        return $that;
	}

    /**
     * @inheritDoc
     */
    public function withLocale(string $locale): EntityInterface
    {
        $that = $this->blueprinted();
        $that->original = $this->original->withLocale($locale);
        return $that;
    }

	/**
	 * @inheritDoc
	 */
	public function withCreated(DateTimeInterface $dt): EntityInterface
	{
        $that = $this->blueprinted();
        $that->original = $this->original->withCreated($dt);
        return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function withChanged(DateTimeInterface $dt): EntityInterface
	{
        $that = $this->blueprinted();
        $that->original = $this->original->withChanged($dt);
        return $that;
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
        try {
            return $this->original->name();
        } catch (DomainException $ex) {
            if ($ex->getCode() === 404 && !$this->loaded) {
                return $this->loaded()->name();
            }
            throw $ex;
        }
	}

    /**
     * @inheritDoc
     * @throws DomainException
     */
    public function locale(): string
    {
        try {
            return $this->original->locale();
        } catch (DomainException $ex) {
            if ($ex->getCode() === 404 && !$this->loaded) {
                return $this->loaded()->locale();
            }
            throw $ex;
        }
    }

	/**
	 * @inheritDoc
	 */
	public function printed(F\PrinterInterface $p)
	{
		if (!$this->loaded && $this->autoload) {
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
		$that = new self($this->original, $this->p, $this->autoload);
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
        echo "\nloaded!\n";
		return $that;
	}
}
