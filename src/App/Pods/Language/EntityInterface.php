<?php

namespace Jigius\LittleSweetPods\App\Pods\Language;

use Jigius\LittleSweetPods\Foundation\MediaInterface;

/**
 * Language entity
 */
interface EntityInterface extends
	MediaInterface,
	IdentificationInterface,
	NameInterface,
    LocaleInterface
{
}
