<?php

namespace Jigius\LittleSweetPods\Foundation;

/**
 * Used for printing the media to a Printer
 */
interface MediaInterface
{
	/**
	 * Prints out the media to a Printer
	 * @param PrinterInterface $p
	 * @return mixed
	 */
	public function printed(PrinterInterface $p);
}
