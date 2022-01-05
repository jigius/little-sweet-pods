<?php

namespace Jigius\LittleSweetPods\App\Pods\Author\Persistence\Pdo;

use Iterator;

interface IteratorInterface extends Iterator
{
    /**
     * @return EntityInterface
     */
    public function current(): EntityInterface;
}
