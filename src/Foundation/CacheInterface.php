<?php

namespace Jigius\LittleSweetPods\Foundation;

interface CacheInterface
{
    /**
     * Fetches a data under the specified key from the cache.
     * If there is no data in the cache and `feed` param is not null - pushes a data,
     * that is returned from `feed`under the specified key in the cache and returns it.
     * @param string $key
     * @param callable|null $feed
     * @return mixed
     */
    public function fetch(string $key, callable $feed = null);

    /**
     * Signs if a data with the specified key is present in the cache
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Pushes a data (that is returned from callee under the specified key) into the cache
     * @param string $key
     * @param callable $callee
     * @return void
     */
    public function push(string $key, callable $callee);

    /**
     * Cleans the cache
     * @return mixed
     */
    public function clean();
}
