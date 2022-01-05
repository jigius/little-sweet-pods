<?php

namespace Jigius\LittleSweetPods\App\Pods\Language;

/**
 * language's title
 */
interface LocaleInterface
{
	/**
	 * Returns language's locale
	 * @return string
	 */
	public function locale(): string;
}
