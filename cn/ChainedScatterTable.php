<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ChainedScatterTable.php,v 1.7 2005/12/09 01:11:09 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractHashTable.php';
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * Represents an entry in a chained scatter table.
 *
 * @package Opus11
 */
class ChainedScatterTable_Entry
{
    /**
     * An object.
     */
    public $object = NULL;
    /**
     * The next element in the chain.
     */
    public $next = ChainedScatterTable::NIL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a ChainedScatterTable_Entry.
     */
    public function __construct()
    {
        $this->object = NULL;
        $this->next = ChainedScatterTable::NIL;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->object = NULL;
        $this->next = ChainedScatterTable::NIL;
    }

    /**
     * Purges this entry, making it empty.
     */
    public function purge()
    {
        $this->object = NULL;
        $this->next = ChainedScatterTable::NIL;
    }
//}>a

}

/**
 * An iterator that enumerates the items in a ChainedScatterTable.
 *
 * @package Opus11
 */
class ChainedScatterTable_Iterator
    extends AbstractIterator
{
    /**
     * @var object ChainedScatterTable The hash table to enumerate.
     */
    protected $hashTable = NULL;
    /**
     * @var integer The offset.
     */
    protected $position = 0;

    /**
     * Constructs a ChainedScatterTable_Iterator for the given hash table.
     *
     * @param object ChainedScatterTable $hashTable A hash table.
     */
    public function __construct(ChainedScatterTable $hashTable)
    {
        parent::__construct();
        $this->hashTable = $hashTable;

        $array = $this->hashTable->getArray();
        for ($this->position = 0;
            $this->position < $array->getLength();
            ++$this->position)
        {
            if ($array[$this->position]->object !== NULL)
                break;
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->hashTable = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
    {
        return $this->position <
            $this->hashTable->getArray()->getLength();
    }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        $array = $this->hashTable->getArray();
        return $array[$this->position]->object;
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        $array = $this->hashTable->getArray();
        for (++$this->position; $this->position <
            $this->hashTable->getArray()->getLength();
            ++$this->position)
        {
            if ($array[$this->position]->object !== NULL)
                break;
        }
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $array = $this->hashTable->getArray();
        for ($this->position = 0;
            $this->position < $array->getLength();
            ++$this->position)
        {
            if ($array[$this->position]->object !== NULL)
                break;
        }
    }
}

//{
/**
 * A chained hash table implemented using an array.
 *
 * @package Opus11
 */
class ChainedScatterTable
    extends AbstractHashTable
{
    /**
     * @var object BasicArray The array.
     */
    protected $array = NULL;
    /**
     * @var integer End of a chain marker.
     */
    const NIL = -1;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a ChainedScatterTable with the given length.
     *
     * @param integer $length The length of this hash table.
     */
    public function __construct($length = 0)
    {
        parent::__construct();
        $this->array = new BasicArray($length);
        for ($i = 0; $i < $length; ++$i)
            $this->array[$i] = new ChainedScatterTable_Entry();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->array = NULL;
        parent::__destruct();
    }

    /**
     * Array getter.
     *
     * @return object BasicArray A reference to the array of this hash table.
     */
    public function & getArray()
    {
        return $this->array;
    }
//}>a

//{
    /**
     * Length getter.
     *
     * @return integer The length of this hash table.
     */
    public function getLength()
    {
        return $this->array->getLength();
    }

    /**
     * Purges this chained hash table, making it empty.
     */
    public function purge()
    {
        for ($i = 0; $i < $this->array->getLength(); ++$i)
            $this->array[$i]->purge();
        $this->count = 0;
    }
//}>b

    /**
     * IsFull predicate.
     *
     * @return boolean True if this chained scatter table is full;
     * false otherwise.
     */
    public function isFull()
    {
        return $this->count == $this->getLength();
    }

//{
    /**
     * Inserts the specified comparable object into this chained scatter table.
     *
     * @param object IComparable $obj The object to insert.
     * @exception ContainerFullException If this chained scatter table is full.
     */
    public function insert(IComparable $obj)
    {
        if ($this->count == $this->getLength())
            throw new ContainerFullException();
        $probe = $this->h($obj);
        if ($this->array[$probe]->object !== NULL)
        {
            while ($this->array[$probe]->next != self::NIL)
                $probe = $this->array[$probe]->next;
            $tail = $probe;
            $probe = ($probe + 1) % $this->getLength();
            while ($this->array[$probe]->object !== NULL)
                $probe = ($probe + 1) % $this->getLength();
            $this->array[$tail]->next = $probe;
        }
        $this->array[$probe]->object = $obj;
        $this->array[$probe]->next = self::NIL;
        ++$this->count;
    }

    /**
     * Finds an object in this chained scatter table
     * that matches the specified object.
     *
     * @param object IComparable $obj The object to match.
     * @return mixed The object in this chained scatter table
     * that matches the specified object;
     * NULL if no match.
     */
    public function find(IComparable $obj)
    {
        for ($probe = $this->h($obj);
            $probe != self::NIL;
            $probe = $this->array[$probe]->next)
        {
            if (eq($obj, $this->array[$probe]->object))
                return $this->array[$probe]->object;
        }
        return NULL;
    }
//}>c

//{
    /**
     * Withdraws the specified object from this chained scatter table.
     *
     * @param object IComparable $obj The object to be withdrawn.
     */
    public function withdraw(IComparable $obj)
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        $i = $this->h($obj);
        while ($i != self::NIL &&
                ne($obj, $this->array[$i]->object))
            $i = $this->array[$i]->next;
        if ($i == self::NIL) throw new ArgumentError();
        for (;;) {
            $j = $this->array[$i]->next;
            while ($j != self::NIL) {
                $h = $this->h($this->array[$j]->object);
                $contained = false;
                for ($k = $this->array[$i]->next;
                    $k != $this->array[$j]->next && !$contained;
                    $k = $this->array[$k]->next) {
                    if ($k == $h) $contained = true;
                }
                if (!$contained) break;
                $j = $this->array[$j]->next;
            }
            if ($j == self::NIL) break;
            $this->array[$i]->object = $this->array[$j]->object;
            $i = $j;
        }
        $this->array[$i]->object = NULL;
        $this->array[$i]->next = self::NIL;
        for ($j = ($i+$this->getLength()-1) % $this->getLength();
            $j != $i;
            $j = ($j+$this->getLength()-1) % $this->getLength()){
            if ($this->array[$j]->next == $i) {
                $this->array[$j]->next = self::NIL;
                break;
            }
        }
        --$this->count;
    }
//}>d

    /**
     * Tests whether the specified object is contained
     * in this chained scatter table.
     *
     * @param object IComparable $obj The object for which to look.
     * @return boolean True if the specified object
     * is in this chained scatter table; false otherwise.
     */
    public function contains(IComparable $obj)
    {
        for ($probe = $this->h($obj);
            $probe != self::NIL;
            $probe = $this->array[$probe]->next)
        {
            if (eq($obj, $this->array[$probe]->object))
                return true;
        }
        return false;
    }

    /**
     * Returns a value computed by calling the given callback function
     * for each item in this container.
     * Each time the callback function will be called with two arguments:
     * The first argument is the next item in this container.
     * The first time the callback function is called,
     * the second argument is the given initial value.
     * On subsequent calls to the callback function,
     * the second argument is the result returned from
     * the previous call to the callback function.
     *
     * @param callback $callback A callback function.
     * @param mixed $initialState The initial state.
     * @return mixed The value returned by
     * the last call to the callback function.
     */
    public function reduce($callback, $initialState)
    {
        $state = $initialState;
        for ($i = 0; $i < $this->array->getLength(); ++$i)
        {
            if ($this->array[$i]->object !== NULL)
            {
                $state = $callback(
                    $state, $this->array[$i]->object);
            }
        }
        return $state;
    }

    /**
     * Returns an iterator that enumerates the objects in this hash table.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new ChainedScatterTable_Iterator($this);
    }

    /**
     * Compares this chained hash table with the specified comparable object.
     * This method is not implemented.
     *
     * @param object IComparable $arg
     * The comparable object to which this chained hash table is compared.
     */
    protected function compareTo(IComparable $arg)
    {
       throw new MethodNotImplementedException();
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("ChainedScatterTable main program.\n");
        $status = 0;
        $hashTable = new ChainedScatterTable(57);
        AbstractHashTable::test($hashTable);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(ChainedScatterTable::main(array_slice($argv, 1)));
}
?>
