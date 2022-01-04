<?php

namespace Jigius\LittleSweetPods\App\Pods\Language;

use Jigius\LittleSweetPods\Foundation\PrinterInterface;
use Jigius\LittleSweetPods\Illuminate\ArrayMedia;
use LogicException;

/**
 * Language-entity
 */
final class EntLanguage implements EntityInterface
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
	public function name(): string
	{
		if (!isset($this->i['name'])) {
			throw new LogicException("not defined");
		}
		return $this->i['name'];
	}

	/**
	 * @inheritDoc
	 */
	public function withName(string $name): self
	{
		$that = $this->blueprinted();
		$that->i['name'] = $name;
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
	 * @return EntLanguage
	 */
	public function blueprinted(): self
	{
		$that = new self();
		$that->i = $this->i;
		return $that;
	}
}
