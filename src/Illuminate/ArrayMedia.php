<?php
namespace Jigius\LittleSweetPods\Illuminate;

use Jigius\LittleSweetPods\Foundation as F;

/**
 * Class ArrayMedia
 * Makes possible to print out an injected value into a printer
 */
final class ArrayMedia implements F\MediaInterface
{
    /**
     * @var array
     */
    private array $i;

    /**
     * Cntr
     * @param array $i
     */
    public function __construct(array $i)
    {
        $this->i = $i;
    }

    /**
     * @inheritDoc
     */
    public function printed(F\PrinterInterface $p)
    {
        foreach ($this->i as $k => $v) {
            $p = $p->with($k, $v);
        }
        return $p->finished();
    }
}
