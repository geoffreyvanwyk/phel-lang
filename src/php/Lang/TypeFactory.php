<?php

declare(strict_types=1);

namespace Phel\Lang;

use Phel\Lang\Collections\HashMap\PersistentHashMap;
use Phel\Lang\Collections\HashSet\PersistentHashSet;
use Phel\Lang\Collections\LinkedList\EmptyList;
use Phel\Lang\Collections\LinkedList\PersistentList;
use Phel\Lang\Collections\Vector\PersistentVector;
use RuntimeException;

class TypeFactory
{
    private HasherInterface $hasher;
    private EqualizerInterface $equalizer;
    private static ?TypeFactory $instance = null;

    public function __construct()
    {
        $this->hasher = new Hasher();
        $this->equalizer = new Equalizer();
    }

    public static function getInstance(): TypeFactory
    {
        if (self::$instance === null) {
            self::$instance = new TypeFactory();
        }

        return self::$instance;
    }

    public function emptyPersistentHashMap(): PersistentHashMap
    {
        return PersistentHashMap::empty($this->hasher, $this->equalizer);
    }

    /**
     * @param mixed[] $kvs
     */
    public function persistentHashMapFromKVs(...$kvs): PersistentHashMap
    {
        if (count($kvs) % 2 !== 0) {
            // TODO: Better exception
            throw new RuntimeException('A even number of elements must be provided');
        }

        $result = PersistentHashMap::empty($this->hasher, $this->equalizer);
        for ($i = 0, $l = count($kvs); $i < $l; $i += 2) {
            $result = $result->put($kvs[$i], $kvs[$i+1]);
        }
        return $result;
    }

    public function emptyPersistentHashSet(): PersistentHashSet
    {
        return new PersistentHashSet($this->hasher, null, $this->emptyPersistentHashMap());
    }

    public function emptyPersistentList(): EmptyList
    {
        return PersistentList::empty($this->hasher, $this->equalizer);
    }

    /**
     * @return PersistentList|EmptyList
     */
    public function emptyPersistentListFromArray(array $values)
    {
        return PersistentList::fromArray($this->hasher, $this->equalizer, $values);
    }

    public function emptyPersistentVector(): PersistentVector
    {
        return PersistentVector::empty($this->hasher, $this->equalizer);
    }

    public function persistentVectorFromArray(array $values): PersistentVector
    {
        return PersistentVector::fromArray($this->hasher, $this->equalizer, $values);
    }

    public function symbol(string $name): Symbol
    {
        return Symbol::create($name);
    }

    public function symbolForNamespace(?string $namespace, string $name): Symbol
    {
        return Symbol::createForNamespace($namespace, $name);
    }

    public function keyword(string $name): Keyword
    {
        return new Keyword($name);
    }
}
