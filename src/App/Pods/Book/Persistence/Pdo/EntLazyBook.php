<?php

namespace Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo;

use DateTimeInterface;
use Jigius\LittleSweetPods\App\Pods\Author;
use Jigius\LittleSweetPods\App\Pods\Language;
use Jigius\LittleSweetPods\Foundation as F;
use LogicException;
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
	public function withIsbn(string $isbn): EntityInterface
	{
		if (!$this->loaded) {
			return $this->loaded()->withIsbn($isbn);
		}
		return $this->original->withIsbn($isbn);
	}

	/**
	 * @inheritDoc
	 */
	public function withPublished(DateTimeInterface $pub): EntityInterface
	{
		if (!$this->loaded) {
			return $this->loaded()->withPublished($pub);
		}
		return $this->original->withPublished($pub);
	}

	/**
	 * @inheritDoc
	 */
	public function withLanguage(Language\EntityInterface $lang): EntityInterface
	{
		if (!$this->loaded) {
			return $this->loaded()->withLanguage($lang);
		}
		return $this->original->withLanguage($lang);
	}

    /**
     * @inheritDoc
     */
    public function withAuthor(Author\Persistence\Pdo\IteratorInterface $author): EntityInterface
    {
        if (!$this->loaded) {
            return $this->loaded()->withAuthor($author);
        }
        return $this->original->withAuthor($author);
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
	public function withTitle(string $title): EntityInterface
	{
		if (!$this->loaded) {
			return $this->loaded()->withTitle($title);
		}
		return $this->original->withTitle($title);
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
            if ($ex->getCode() === 404 && !$this->loaded) {
                return $this->loaded()->isbn();
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
            if ($ex->getCode() === 404 && !$this->loaded) {
                return $this->loaded()->language();
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
            if ($ex->getCode() === 404 && !$this->loaded) {
                return $this->loaded()->author();
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
	 * @inheritDoc
     * @throws DomainException
	 */
	public function published(): DateTimeInterface
	{
        try {
            return $this->original->published();
        } catch (DomainException $ex) {
            if ($ex->getCode() === 404 && !$this->loaded) {
                return $this->loaded()->published();
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
            if ($ex->getCode() === 404 && !$this->loaded) {
                return $this->loaded()->title();
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
		$that = new self($this->original, $this->p, $this->autoload);
		$that->loaded = $this->loaded;
		return $that;
	}

	/**
	 * Loads data for the entity from the persistence layer
	 * @return EntLazyBook
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
