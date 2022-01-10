<?php

namespace Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo;

use DateTimeInterface;
use Jigius\LittleSweetPods\App\Pods\Author;
use Jigius\LittleSweetPods\App\Pods\Language;
use Jigius\LittleSweetPods\Foundation as F;
use DomainException;

/**
 * Book-entity with capable of lazy loading from the persistence layer into Db
 */
final class EntLazyBook implements EntityInterface
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
	public function withIsbn(string $isbn): EntityInterface
	{
        $that = $this->blueprinted();
        $that->original = $this->original->withIsbn($isbn);
        return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function withPublished(DateTimeInterface $pub): EntityInterface
	{
        $that = $this->blueprinted();
        $that->original = $this->original->withPublished($pub);
        return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function withLanguage(Language\EntityInterface $lang): EntityInterface
	{
        $that = $this->blueprinted();
        $that->original = $this->original->withLanguage($lang);
        return $that;
	}

    /**
     * @inheritDoc
     */
    public function withAuthor(Author\Persistence\Pdo\IteratorInterface $author): EntityInterface
    {
        $that = $this->blueprinted();
        $that->original = $this->original->withAuthor($author);
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
	public function withTitle(string $title): EntityInterface
	{
        $that = $this->blueprinted();
        $that->original = $this->original->withTitle($title);
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
     * @throws DomainException
	 */
	public function isbn(): string
	{
        try {
            return $this->original->isbn();
        } catch (DomainException $ex) {
            if ($ex->getCode() === 404 && !$this->loaded()) {
                $this->load();
                return $this->original->isbn();
            }
            throw $ex;
        }
	}

	/**
	 * @inheritDoc
     * @throws DomainException
	 */
	public function language(): Language\EntityInterface
	{
        try {
            return $this->original->language();
        } catch (DomainException $ex) {
            if ($ex->getCode() === 404 && !$this->loaded()) {
                $this->load();
                return $this->original->language();
            }
            throw $ex;
        }
	}

    /**
     * @inheritDoc
     * @throws DomainException
     */
    public function author(): Author\IteratorInterface
    {
        try {
            return $this->original->author();
        } catch (DomainException $ex) {
            if ($ex->getCode() === 404 && !$this->loaded()) {
                $this->load();
                return $this->original->author();
            }
            throw $ex;
        }
    }

    /**
	 * @inheritDoc
	 */
	public function printed(F\PrinterInterface $p)
	{
		if (!$this->cache->has($this->id()) && $this->autoload) {
            $this->load();
		}
		return $this->original->printed($p);
	}

	/**
	 * @inheritDoc
     * @throws DomainException
	 */
	public function published(): DateTimeInterface
	{
        try {
            return $this->original->published();
        } catch (DomainException $ex) {
            if ($ex->getCode() === 404 && !$this->loaded()) {
                $this->load();
                return $this->original->published();
            }
            throw $ex;
        }
	}

	/**
	 * @inheritDoc
     * @throws DomainException
	 */
	public function title(): string
	{
        try {
            return $this->original->title();
        } catch (DomainException $ex) {
            if ($ex->getCode() === 404 && !$this->loaded()) {
                $this->load();
                return $this->original->title();
            }
            throw $ex;
        }
	}

	/**
	 * Clones the instance
	 * @return EntLazyBook
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
