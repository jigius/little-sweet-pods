<?php

namespace Jigius\LittleSweetPods\App\Pods\Language\Persistence\Pdo;

use Jigius\LittleSweetPods\Foundation as F;
use Jigius\LittleSweetPods\Illuminate as I;
use DateTimeInterface;
use DateTimeImmutable;
use DateTimeZone;
use Exception;
use LogicException;

/**
 * Language-entity with persistence into Db capable
 */
final class EntLanguage implements EntityInterface
{
	/**
	 * @var array
	 */
	private array $i;

	public function __construct()
	{
		$this->i = [
			'persisted' => false
		];
	}

    /**
     * @inheritDoc
     * @throws LogicException
     */
    public function id(): int
    {
        if (!isset($this->i['id'])) {
            throw new LogicException("not defined");
        }
        return $this->i['id'];
    }

    /**
     * @inheritDoc
     */
    public function withId(int $id): self
    {
        $that = $this->blueprinted();
        $that->i['id'] = $id;
        return $that;
    }

	/**
	 * @inheritDoc
	 */
	public function name(): string
	{
        if (!isset($this->i['name'])) {
            throw new LogicException("not defined");
        }
        return $this->i['name'];
	}

	/**
	 * @inheritDoc
	 */
	public function withLocale(string $locale): self
	{
        $that = $this->blueprinted();
        $that->i['locale'] = $locale;
        return $that;
	}

    /**
     * @inheritDoc
     */
    public function locale(): string
    {
        if (!isset($this->i['locale'])) {
            throw new LogicException("not defined");
        }
        return $this->i['locale'];
    }

    /**
     * @inheritDoc
     */
    public function withName(string $name): self
    {
        $that = $this->blueprinted();
        $that->i['name'] = $name;
        return $that;
    }

	/**
	 * @inheritDoc
	 * @throws Exception
	 */
	public function printed(F\PrinterInterface $p)
	{
        $p =
            (new I\ArrayMedia($this->i))
                ->printed(
                    new I\PrnWithSuppressedFinished($p)
                );
        foreach (['created', 'changed'] as $prop) {
            if (!isset($this->i[$prop])) {
                $p = $p->with($prop, new DateTimeImmutable("now", new DateTimeZone("UTC")));
            }
        }
        return
            $p
                ->original()
                ->finished();
	}

	/**
	 * @inheritDoc
	 */
	public function withCreated(DateTimeInterface $dt): self
	{
		$that = $this->blueprinted();
		$that->i['created'] = $dt;
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function withChanged(DateTimeInterface $dt): self
	{
		$that = $this->blueprinted();
		$that->i['changed'] = $dt;
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function withPersisted(bool $flag): self
	{
		$that = $this->blueprinted();
		$that->i['persisted'] = $flag;
		return $that;
	}

	/**
	 * Clones the instance
	 * @return EntLanguage
	 */
	public function blueprinted(): self
	{
		$that = new self();
		$that->i = $this->i;
		return $that;
	}
}
