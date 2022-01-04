<?php

namespace Jigius\LittleSweetPods\Illuminate;

use Jigius\LittleSweetPods\Foundation\PrinterInterface;

/**
 * Prints out a Media as an array. There are some filtering capabilities.
 */
final class PrnArray implements PrinterInterface
{
	/**
	 * @var array
	 */
	private array $includes;
	/**
	 * @var array
	 */
	private array $excludes;
	/**
	 * @var array
	 */
	private array $i;

	/**
	 * Cntr
	 * @param array $includes
	 * @param array $excludes
	 */
	public function __construct(array $includes = [], array $excludes = [])
	{
		$this->i = [];
		$this->includes = $includes;
		$this->excludes = $excludes;
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
	 * @inheritDoc
	 * @return array
	 */
	public function finished(): array
	{
		return
			array_filter(
				$this->i,
				function ($key): bool {
					return
						in_array($key, $this->includes) ||
						(
							empty($this->includes) && !in_array($key, $this->excludes)
						);
				},
				ARRAY_FILTER_USE_KEY
			);
	}

	/**
	 * Clones the instance
	 * @return PrnArray
	 */
	public function blueprinted(): self
	{
		$that = new self($this->includes, $this->excludes);
		$that->i = $this->i;
		return $that;
	}
}
