<?php

namespace Jigius\LittleSweetPods\App\Pods\Book;

use DateTimeInterface;
use Jigius\LittleSweetPods\App\Pods\Language;
use Jigius\LittleSweetPods\Foundation\PrinterInterface;
use Jigius\LittleSweetPods\Illuminate\ArrayMedia;
use LogicException;

/**
 * Book-entity
 */
final class EntBook implements EntityInterface
{
	/**
	 * @var array
	 */
	private array $i;

	public function __construct()
	{
		$this->i = [];
	}

	/**
	 * @inheritDoc
	 * @throws LogicException
	 */
	public function id(): int
	{
		if (!isset($this->i['id'])) {
			throw new LogicException("not defined");
		}
		return $this->i['id'];
	}

	/**
	 * @inheritDoc
	 */
	public function withId(int $id): self
	{
		$that = $this->blueprinted();
		$that->i['id'] = $id;
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function isbn(): string
	{
		if (!isset($this->i['isbn'])) {
			throw new LogicException("not defined");
		}
		return $this->i['isbn'];
	}

	/**
	 * @inheritDoc
	 */
	public function withIsbn(string $isbn): self
	{
		$that = $this->blueprinted();
		$that->i['isbn'] = $isbn;
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function title(): string
	{
		if (!isset($this->i['title'])) {
			throw new LogicException("not defined");
		}
		return $this->i['title'];
	}

	/**
	 * @inheritDoc
	 */
	public function withTitle(string $title): self
	{
		$that = $this->blueprinted();
		$that->i['title'] = $title;
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function published(): DateTimeInterface
	{
		if (!isset($this->i['published'])) {
			throw new LogicException("not defined");
		}
		return $this->i['published'];
	}

	/**
	 * @inheritDoc
	 */
	public function withPublished(DateTimeInterface $pub): self
	{
		$that = $this->blueprinted();
		$that->i['published'] = $pub;
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function language(): Language\EntityInterface
	{
		if (!isset($this->i['language'])) {
			throw new LogicException("not defined");
		}
		return $this->i['language'];
	}

	/**
	 * @inheritDoc
	 */
	public function withLanguage(Language\EntityInterface $lang): self
	{
		$that = $this->blueprinted();
		$that->i['language'] = $lang;
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function printed(PrinterInterface $p)
	{
		return (new ArrayMedia($this->i))->printed($p);
	}

	/**
	 * Clones the instance
	 * @return EntBook
	 */
	public function blueprinted(): self
	{
		$that = new self();
		$that->i = $this->i;
		return $that;
	}
}
