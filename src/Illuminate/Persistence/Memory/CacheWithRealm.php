<?php

namespace Jigius\LittleSweetPods\Illuminate\Persistence\Memory;

use Jigius\LittleSweetPods\Foundation as F;

/**
 * Modifies a key, that is used for interacting with the cache,
 * based on the original key value and defined realm value
 */
final class CacheWithRealm implements F\CacheInterface
{
    /**
     * @var F\CacheInterface
     */
    private F\CacheInterface $original;
    /**
     * @var string
     */
    private string $realm;

    public function __construct(F\CacheInterface $cache, string $realm)
    {
        $this->original = $cache;
        $this->realm = $realm;
    }

    /**
     * @inheritDoc
     */
    public function fetch(string $key, callable $feed = null)
    {
        return $this->original->fetch($this->key($key), $feed);
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        return $this->original->has($this->key($key));
    }

    /**
     * @inheritDoc
     */
    public function push(string $key, callable $callee)
    {
        return $this->original->fetch($this->key($key), $callee);
    }

    /**
     * @inheritDoc
     */
    public function clean()
    {
        $this->original->clean();
    }

    /**
     * Generates a new key is used for the data fetching
     * @param string $key
     * @return string
     */
    private function key(string $key): string
    {
        return "$this->realm@$key";
    }
}
