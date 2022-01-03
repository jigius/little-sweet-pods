<?php

namespace Jigius\LittleSweetPods\Illuminate;

use Jigius\LittleSweetPods\Foundation as F;

/**
 * Suppresses the finished-method. Instead it returns the instance
 */
final class PrnWithSuppressedFinished implements PrnWithSuppressedFinishedInterface
{
	/**
	 * @var F\PrinterInterface
	 */
	private F\PrinterInterface $original;

	public function __construct(F\PrinterInterface $p)
	{
		$this->original = $p;
	}

	/**
	 * @inheritDoc
	 */
	public function with(string $key, $val): PrnWithSuppressedFinishedInterface
	{
		$that = $this->blueprinted();
		$that->original = $this->original->with($key, $val);
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function original(): F\PrinterInterface
	{
		return $this->original;
	}

	/**
	 * @inheritDoc
	 */
	public function finished(): PrnWithSuppressedFinishedInterface
	{
		return $this;
	}

	/**
	 * Clones the instance
	 * @return PrnWithSuppressedFinished
	 */
	public function blueprinted(): self
	{
		return new self($this->original);
	}
}
