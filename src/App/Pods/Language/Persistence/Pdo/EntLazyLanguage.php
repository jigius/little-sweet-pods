<?php

namespace Jigius\LittleSweetPods\App\Pods\Language\Persistence\Pdo;

use DateTimeInterface;
use Jigius\LittleSweetPods\Foundation as F;
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
     * Defines if the entity has to be loaded before it will be printed
     * @var bool
     */
    private bool $autoload;
    /**
     * @var F\CacheInterface
     */
    private F\CacheInterface $cache;

    /**
     * Cntr
     * @param F\CacheInterface $cache
     * @param EntityInterface $entity
     * @param PrinterEntityInterface $p
     * @param bool $loadBeforePrinted Defines if the entity has to be loaded before it will be printed
     */
	public function __construct(
        F\CacheInterface $cache,
        EntityInterface $entity,
        PrinterEntityInterface $p,
        bool $loadBeforePrinted = false
    ) {
        $this->cache = $cache;
		$this->original = $entity;
		$this->p = $p;
        $this->autoload = $loadBeforePrinted;
	}

	/**
	 * @inheritDoc
	 */
	public function withPersisted(bool $flag): EntityInterface
	{
        $that = $this->blueprinted();
        $that->original = $this->original->withPersisted($flag);
        return $that;
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
            if ($ex->getCode() === 404 && !$this->loaded()) {
                $this->load();
                return $this->original->name();
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
            if ($ex->getCode() === 404 && !$this->loaded()) {
                $this->load();
                return $this->original->locale();
            }
            throw $ex;
        }
    }

	/**
	 * @inheritDoc
	 */
	public function printed(F\PrinterInterface $p)
	{
		if (!$this->loaded() && $this->autoload) {
			$this->load();
		}
		return $this->original->printed($p);
	}

	/**
	 * Clones the instance
	 * @return EntLazyLanguage
	 */
	public function blueprinted(): self
	{
		return new self($this->cache, $this->original, $this->p, $this->autoload);
	}

    /**
     * Signs if the original entity has been loaded from the persistence layer
     * @return bool
     */
    private function loaded(): bool
    {
        return $this->cache->has($this->id());
    }

	/**
	 * Loads data for the entity from the persistence layer
     * The instance is mutating!
	 * @return void
	 */
	private function load(): void
	{
        $this->original =
            $this
                ->cache
                ->fetch(
                    $this->id(),
                    function (): EntityInterface {
                        return
                            $this
                                ->p
                                ->with('id', $this->id())
                                ->finished();
                    }
                );
	}
}
