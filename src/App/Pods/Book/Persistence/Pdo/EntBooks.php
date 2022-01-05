<?php

namespace Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo;

use IteratorIterator;
use Traversable;

/**
 *
 */
final class EntBooks extends IteratorIterator implements IteratorInterface
{
    /**
     * @param Traversable $iterator
     */
    public function __construct(Traversable $iterator)
    {
        parent::__construct($iterator);
    }

    /**
     * @inheritDoc
     */
    public function current(): EntityInterface
    {
        return parent::current();
    }
}
