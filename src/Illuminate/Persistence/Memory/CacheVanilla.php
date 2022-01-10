<?php
namespace Jigius\LittleSweetPods\Illuminate\Persistence\Memory;

use Jigius\LittleSweetPods\Foundation\CacheInterface;
use OutOfBoundsException;

/**
 * Simple implementation a cache instance with the data memorizing into Memory
 */
final class CacheVanilla implements CacheInterface
{
    /**
     * @var array
     */
    private array $i;

    /**
     * Cntr
     */
    public function __construct()
    {
        $this->i = [];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->i);
    }

    /**
     * @inheritDoc
     */
    public function fetch(string $key, callable $feed = null)
    {
        if (!$this->has($key)) {
            if ($feed !== null) {
                $this->i[$key] = call_user_func($feed);
            } else {
                throw new OutOfBoundsException("data with key=`$key` is not found");
            }
        }
        return $this->i[$key];
    }

    /**
     * @inheritDoc
     */
    public function push(string $key, callable $callee)
    {
        $this->i[$key] = call_user_func($callee);
    }

    /**
     * @inheritDoc
     */
    public function clean()
    {
        $this->i = [];
    }
}
