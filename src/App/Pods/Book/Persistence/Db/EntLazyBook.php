<?php

namespace Jigius\LittleSweetPods\App\Pods\Book\Persistence\Db;

use DateTimeInterface;
use Jigius\LittleSweetPods\App\Pods\Language;
use Jigius\LittleSweetPods\Foundation\Persistence\RepositoryInterface;
use Jigius\LittleSweetPods\Foundation\PrinterInterface;
use Jigius\LittleSweetPods\App\Pods\Book as Vanilla;

final class EntLazyBook implements EntityInterface
{
	/**
	 * @var RepositoryInterface
	 */
	private RepositoryInterface $r;
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
	 * @param EntityInterface $entity
	 * @param RepositoryInterface $r
	 */
	public function __construct(EntityInterface $entity, RepositoryInterface $r)
	{
		$this->original = $entity;
		$this->r = $r;
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
	public function withLanguage(Language\LanguageInterface $lang): Vanilla\EntityInterface
	{
		if (!$this->loaded) {
			return $this->loaded()->withLanguage($lang);
		}
		return $this->original->withLanguage($lang);
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
	public function withTitle(string $title): Vanilla\EntityInterface
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
	 */
	public function isbn(): string
	{
		if (!$this->loaded) {
			return $this->loaded()->isbn();
		}
		return $this->original->isbn();
	}

	/**
	 * @inheritDoc
	 */
	public function language(): Language\EntityInterface
	{
		if (!$this->loaded) {
			return $this->loaded()->language();
		}
		return $this->original->language();
	}

	/**
	 * @inheritDoc
	 */
	public function printed(PrinterInterface $p)
	{
		if (!$this->loaded) {
			return $this->loaded()->printed($p);
		}
		return $this->original->printed($p);
	}

	/**
	 * @inheritDoc
	 */
	public function published(): DateTimeInterface
	{
		if (!$this->loaded) {
			return $this->loaded()->published();
		}
		return $this->original->published();
	}

	/**
	 * @inheritDoc
	 */
	public function title(): string
	{
		if (!$this->loaded) {
			return $this->loaded()->title();
		}
		return $this->original->title();
	}

	/**
	 * Clones the instance
	 * @return EntLazyBook
	 */
	public function blueprinted(): self
	{
		$that = new self($this->original, $this->r);
		$that->loaded = $this->loaded;
		return $that;
	}

	/**
	 * loads data for the entity from the persistence layer
	 * @return $this
	 */
	private function loaded(): self
	{
		// FIXME!!!
		return $this;
	}

}