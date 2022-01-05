<?php

namespace Jigius\LittleSweetPods\App\Pods\Book\Persistence\Pdo;

use DateTimeInterface;
use Jigius\LittleSweetPods\App\Pods\Author;
use Jigius\LittleSweetPods\App\Pods\Language;
use Jigius\LittleSweetPods\Foundation\PrinterInterface;
use Jigius\LittleSweetPods\Illuminate\ArrayMedia;
use Jigius\LittleSweetPods\Illuminate\PrnWithSuppressedFinished;
use DateTimeImmutable;
use DateTimeZone;
use Exception;
use LogicException;

/**
 * Book-entity with persistence into Db capable
 */
final class EntBook implements EntityInterface
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
     * @throws LogicException
	 */
	public function isbn(): string
	{
        if (!isset($this->i['isbn'])) {
            throw new LogicException("not defined");
        }
        return $this->i['isbn'];
	}

	/**
	 * @inheritDoc
	 */
	public function withIsbn(string $isbn): self
	{
        $that = $this->blueprinted();
        $that->i['isbn'] = $isbn;
        return $that;
	}

	/**
	 * @inheritDoc
     * @throws LogicException
	 */
	public function title(): string
	{
        if (!isset($this->i['title'])) {
            throw new LogicException("not defined");
        }
        return $this->i['title'];
	}

	/**
	 * @inheritDoc
	 */
	public function withTitle(string $title): self
	{
        $that = $this->blueprinted();
        $that->i['title'] = $title;
        return $that;
	}

	/**
	 * @inheritDoc
     * @throws LogicException
	 */
	public function published(): DateTimeInterface
	{
        if (!isset($this->i['published'])) {
            throw new LogicException("not defined");
        }
        return $this->i['published'];
	}

	/**
	 * @inheritDoc
	 */
	public function withPublished(DateTimeInterface $pub): self
	{
        $that = $this->blueprinted();
        $that->i['published'] = $pub;
        return $that;
	}

	/**
	 * @inheritDoc
     * @throws LogicException
	 */
	public function language(): Language\EntityInterface
	{
        if (!isset($this->i['language'])) {
            throw new LogicException("not defined");
        }
        return $this->i['language'];
	}

	/**
	 * @inheritDoc
	 */
	public function withLanguage(Language\EntityInterface $lang): self
	{
        $that = $this->blueprinted();
        $that->i['language'] = $lang;
        return $that;
	}

    /**
     * @inheritDoc
     * @throws LogicException
     */
    public function author(): Author\IteratorInterface
    {
        if (!isset($this->i['author'])) {
            throw new LogicException("not defined");
        }
        return $this->i['author'];
    }

    /**
     * @inheritDoc
     */
    public function withAuthor(Author\Persistence\Pdo\IteratorInterface $author): EntityInterface
    {
        $that = $this->blueprinted();
        $that->i['author'] = $author;
        return $that;
    }

    /**
	 * @inheritDoc
	 * @throws Exception
	 */
	public function printed(PrinterInterface $p)
	{
		$p =
            (new ArrayMedia($this->i))
                ->printed(
                    new PrnWithSuppressedFinished($p)
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
	 * @return EntBook
	 */
	public function blueprinted(): self
	{
		$that = new self();
		$that->i = $this->i;
		return $that;
	}
}
