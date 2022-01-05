<?php

namespace Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo;

use Iterator;

interface IteratorInterface extends Iterator
{
    /**
     * @return EntityInterface
     */
    public function current(): EntityInterface;
}
