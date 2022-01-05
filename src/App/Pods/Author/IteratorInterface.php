<?php

namespace Jigius\LittleSweetPods\App\Pods\Author;

use Iterator;

interface IteratorInterface extends Iterator
{
    /**
     * @return EntityInterface
     */
    public function current(): EntityInterface;
}
