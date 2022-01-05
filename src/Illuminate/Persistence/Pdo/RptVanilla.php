<?php

namespace Jigius\LittleSweetPods\Illuminate\Persistence\Pdo;

use PDOStatement;
use PDO;

/**
 * Trivial Repository implementation for Db persistence layer with PDO
 */
final class RptVanilla implements RepositoryInterface
{
    /**
     * @var PDO
     */
    private PDO $pdo;

    /**
     * Cntr
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @inheritDoc
     */
    public function executed(RequestInterface $r): PDOStatement
    {
        return $r->executed($this->pdo);
    }
}
