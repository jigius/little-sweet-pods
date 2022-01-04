<?php

namespace Jigius\LittleSweetPods\App\Pods\Language\Persistence\Pdo;

use Jigius\LittleSweetPods\App\Pods\Language as Vanilla;
use Jigius\LittleSweetPods\Foundation\PrinterInterface;
use Jigius\LittleSweetPods\Illuminate\ArrayMedia;
use Jigius\LittleSweetPods\Illuminate\PrnWithSuppressedFinished;
use DateTimeInterface;
use DateTimeImmutable;
use DateTimeZone;
use Exception;

/**
 * Language-entity with persistence into Db capable
 */
final class EntLanguage implements EntityInterface
{
	/**
	 * @var Vanilla\EntityInterface
	 */
	private Vanilla\EntityInterface $original;
	/**
	 * @var array
	 */
	private array $i;

	public function __construct(Vanilla\EntityInterface $lang)
	{
		$this->original = $lang;
		$this->i = [
			'persisted' => false
		];
	}

	/**
	 * @inheritDoc
	 */
	public function id(): int
	{
		return $this->original->id();
	}

	/**
	 * @inheritDoc
	 */
	public function withId(int $id): self
	{
		$that = $this->blueprinted();
		$that->original = $this->original->withId($id);
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function name(): string
	{
		return $this->original->name();
	}

	/**
	 * @inheritDoc
	 */
	public function withName(string $name): self
	{
		$that = $this->blueprinted();
		$that->original = $this->original->withName($name);
		return $that;
	}

	/**
	 * @inheritDoc
	 * @throws Exception
	 */
	public function printed(PrinterInterface $p)
	{
		$p =
			$this
				->original
				->printed(
					(new ArrayMedia($this->i))
						->printed(
							new PrnWithSuppressedFinished($p)
						)
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
		$that = new self($this->original);
		$that->i = $this->i;
		return $that;
	}
}
