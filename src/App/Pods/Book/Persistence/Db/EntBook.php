<?php

namespace Jigius\LittleSweetPods\App\Pods\Book\Persistence\Db;

use DateTimeInterface;
use Jigius\LittleSweetPods\App\Pods\Book as Vanilla;
use Jigius\LittleSweetPods\App\Pods\Language;
use Jigius\LittleSweetPods\Foundation\PrinterInterface;
use Jigius\LittleSweetPods\Illuminate\ArrayMedia;
use Jigius\LittleSweetPods\Illuminate\PrnWithSuppressedFinished;
use DateTimeImmutable;
use DateTimeZone;
use Exception;

/**
 * Book-entity with persistence capable
 */
final class EntBook implements EntityInterface
{
	/**
	 * @var Vanilla\EntityInterface
	 */
	private Vanilla\EntityInterface $original;
	/**
	 * @var array
	 */
	private array $i;

	public function __construct(Vanilla\EntityInterface $book)
	{
		$this->original = $book;
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
	public function withId(int $id): Vanilla\EntityInterface
	{
		$that = $this->blueprinted();
		$that->original = $this->original->withId($id);
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function isbn(): string
	{
		return $this->original->isbn();
	}

	/**
	 * @inheritDoc
	 */
	public function withIsbn(string $isbn): Vanilla\EntityInterface
	{
		$that = $this->blueprinted();
		$that->original = $this->original->withIsbn($isbn);
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function title(): string
	{
		return $this->original->title();
	}

	/**
	 * @inheritDoc
	 */
	public function withTitle(string $title): Vanilla\EntityInterface
	{
		$that = $this->blueprinted();
		$that->original = $this->original->withTitle($title);
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function published(): DateTimeInterface
	{
		return $this->original->published();
	}

	/**
	 * @inheritDoc
	 */
	public function withPublished(DateTimeInterface $pub): Vanilla\EntityInterface
	{
		$that = $this->blueprinted();
		$that->original = $this->original->withPublished($pub);
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function language(): Language\EntityInterface
	{
		return $this->original->language();
	}

	/**
	 * @inheritDoc
	 */
	public function withLanguage(Language\LanguageInterface $lang): Vanilla\EntityInterface
	{
		$that = $this->blueprinted();
		$that->original = $this->original->withLanguage($lang);
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
	public function withCreated(DateTimeInterface $dt): EntityInterface
	{
		$that = $this->blueprinted();
		$that->i['created'] = $dt;
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function withChanged(DateTimeInterface $dt): EntityInterface
	{
		$that = $this->blueprinted();
		$that->i['changed'] = $dt;
		return $that;
	}

	/**
	 * @inheritDoc
	 */
	public function withPersisted(bool $flag): EntityInterface
	{
		$that = $this->blueprinted();
		$that->i['persisted'] = $flag;
		return $that;
	}

	/**
	 * Clones the instance
	 * @return EntBook
	 */
	public function blueprinted(): self
	{
		$that = new self($this->original);
		$that->i = $this->i;
		return $that;
	}
}
