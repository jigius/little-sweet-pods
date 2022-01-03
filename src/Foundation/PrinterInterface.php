<?php

namespace Jigius\LittleSweetPods\Foundation;

/**
 * Used for printout a media
 */
interface PrinterInterface
{
	/**
	 * Defines a portion of data
	 * @param string $key a name of a portion of data
	 * @param mixed $val a portion of data
	 * @return PrinterInterface
	 */
    public function with(string $key, $val): PrinterInterface;

	/**
	 * Handles passed data and returns a result
	 * @return mixed
	 */
    public function finished();
}
