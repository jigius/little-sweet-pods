<?php

namespace Jigius\LittleSweetPods\Illuminate;

use Jigius\LittleSweetPods\Foundation as F;

/**
 * Printer with suppressed finished-method
 */
interface PrnWithSuppressedFinishedInterface extends F\PrinterInterface
{
	/**
	 * @inheritDoc
	 * @return PrnWithSuppressedFinishedInterface
	 */
	public function with(string $key, $val): PrnWithSuppressedFinishedInterface;

	/**
	 * Returns the instance
	 * @return PrnWithSuppressedFinishedInterface
	 */
	public function finished(): PrnWithSuppressedFinishedInterface;

	/**
	 * Returns original instance
	 * @return F\PrinterInterface
	 */
	public function original(): F\PrinterInterface;
}
