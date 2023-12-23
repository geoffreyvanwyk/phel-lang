<?php

declare(strict_types=1);

namespace Phel\Lang\Collections\LinkedList;

use EmptyIterator;
use Exception;
use Phel\Lang\AbstractType;
use Phel\Lang\Collections\Exceptions\IndexOutOfBoundsException;
use Phel\Lang\Collections\Map\PersistentMapInterface;
use Phel\Lang\EqualizerInterface;
use Phel\Lang\HasherInterface;
use RuntimeException;
use Traversable;

/**
 * @template T
 *
 * @implements PersistentListInterface<T>
 *
 * @extends AbstractType<PersistentList<T>>
 */
class EmptyList extends AbstractType implements PersistentListInterface
{
    public function __construct(
        private readonly HasherInterface $hasher,
        private readonly EqualizerInterface $equalizer,
        private readonly ?PersistentMapInterface $meta,
    ) {
    }

    public function getMeta(): ?PersistentMapInterface
    {
        return $this->meta;
    }

    public function withMeta(?PersistentMapInterface $meta)
    {
        return new self($this->hasher, $this->equalizer, $meta);
    }

    /**
     * @param T $value
     *
     * @return PersistentListInterface<T>
     */
    public function prepend($value): PersistentListInterface
    {
        return new PersistentList($this->hasher, $this->equalizer, $this->meta, $value, $this, 1);
    }

    public function pop(): PersistentListInterface
    {
        throw new RuntimeException('Cannot pop empty list');
    }

    public function count(): int
    {
        return 0;
    }

    /**
     * @throws IndexOutOfBoundsException
     */
    public function get(int $i): never
    {
        throw new IndexOutOfBoundsException('Index out of bounds');
    }

    public function equals(mixed $other): bool
    {
        return $other instanceof self;
    }

    public function hash(): int
    {
        return 1;
    }

    public function getIterator(): Traversable
    {
        return new EmptyIterator();
    }

    public function first()
    {
        return null;
    }

    /**
     * @return EmptyList
     */
    public function rest()
    {
        return $this;
    }

    public function cdr()
    {
        return null;
    }

    public function toArray(): array
    {
        return [];
    }

    /**
     * Concatenates a value to the data structure.
     *
     * @param array<int, mixed> $xs The value to concatenate
     *
     * @return PersistentListInterface
     */
    public function concat($xs)
    {
        return PersistentList::fromArray($this->hasher, $this->equalizer, $xs);
    }

    /**
     * @return PersistentListInterface
     */
    public function cons(mixed $x)
    {
        return $this->prepend($x);
    }

    /**
     * @param int $offset
     */
    public function offsetExists($offset): bool
    {
        return false;
    }

    /**
     * @param int $offset
     *
     * @return mixed|null
     */
    public function offsetGet($offset): mixed
    {
        $this->get($offset);
    }

    public function offsetSet($offset, $value): void
    {
        throw new Exception('offsetSet not supported on lists');
    }

    public function offsetUnset($offset): void
    {
        throw new Exception('offsetUnset not supported on lists');
    }

    public function contains($key): bool
    {
        return false;
    }
}
