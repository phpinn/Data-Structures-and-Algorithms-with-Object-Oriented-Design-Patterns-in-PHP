<?php
/**
 * @copyright Copyright &copy; 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: OpenScatterTable.php,v 1.6 2005/12/09 01:11:14 brpreiss Exp $
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
 * Represents an entry in a open scatter table.
 *
 * @package Opus11
 */
class OpenScatterTable_Entry
{
    /**
     * The state of this entry.
     */
    public $state = OpenScatterTable::_EMPTY;
    /**
     * An object.
     */
    public $object = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a OpenScatterTable_Entry.
     */
    public function __construct()
    {
        $this->state = OpenScatterTable::_EMPTY;
        $this->object = NULL;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->next = OpenScatterTable::_EMPTY;
        $this->object = NULL;
    }

    /**
     * Purges this entry, making it empty.
     */
    public function purge()
    {
        $this->next = OpenScatterTable::_EMPTY;
        $this->object = NULL;
    }
//}>a

}

/**
 * An iterator that enumerates the items in a OpenScatterTable.
 *
 * @package Opus11
 */
class OpenScatterTable_Iterator
    extends AbstractIterator
{
    /**
     * @var object OpenScatterTable The hash table to enumerate.
     */
    protected $hashTable = NULL;
    /**
     * @var integer The position.
     */
    protected $position = 0;

    /**
     * Constructs a OpenScatterTable_Iterator for the given hash table.
     *
     * @param object OpenScatterTable $hashTable A hash table.
     */
    public function __construct(OpenScatterTable $hashTable)
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
 * A open scatter table implemented using an array.
 *
 * @package Opus11
 */
class OpenScatterTable
    extends AbstractHashTable
{
    /**
     * @var object BasicArray The array.
     */
    protected $array = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * An empty entry.
     */
    const _EMPTY = 0;
    /**
     * An occupied entry.
     */
    const OCCUPIED = 1;
    /**
     * An unoccupied entry
     */
    const DELETED = 2;

    /**
     * Constructs a OpenScatterTable with the given length.
     *
     * @param integer $length The length of this hash table.
     */
    public function __construct($length = 0)
    {
        parent::__construct();
        $this->array = new BasicArray($length);
        for ($i = 0; $i < $length; ++$i)
            $this->array[$i] = new OpenScatterTable_Entry();
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
     * Purges this open scatter table, making it empty.
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
     * @return boolean True if this open scatter table is full; false otherwise.
     */
    public function isFull()
    {
        return $this->count == $this->getLength();
    }

//{
    /**
     * Implements the linear-probing collision resolution strategy.
     *
     * @param integer $i The probe number.
     * @return integer The i-th position to probe.
     */
    protected function c($i)
    {
        return $i;
    }

    /**
     * Finds the position of an unoccupied entry into which
     * the specified object can be stored.
     *
     * @param object IComparable $obj The object to be stored.
     * @return integer The position of an unoccupied entry.
     */
    protected function findUnoccupied(IComparable $obj)
    {
        $hash = $this->h($obj);
        for ($i = 0; $i < $this->count + 1; ++$i)
        {
            $probe = ($hash + $this->c($i)) % $this->getLength();
            if ($this->array[$probe]->state != self::OCCUPIED)
                return $probe;
        }
        throw new ContainerFullException();
    }

    /**
     * Inserts the specified comparable object into this open scatter table.
     *
     * @param object IComparable $obj The object to insert.
     */
    public function insert(IComparable $obj)
    {
        if ($this->count == $this->getLength())
            throw new ContainerFullException();
        $offset = $this->findUnoccupied($obj);
        $this->array[$offset]->state = self::OCCUPIED;
        $this->array[$offset]->object = $obj;
        ++$this->count;
    }
//}>c

//{
    /**
     * Finds the position of an object in this open scatter table
     * that matches the given object.
     *
     * @param object IComparable $obj The object to match.
     * @return integer The position of the matching object; -1 if no match.
     */
    protected function findMatch(IComparable $obj)
    {
        $hash = $this->h($obj);
        for ($i = 0; $i < $this->getLength(); ++$i)
        {
            $probe = ($hash + $this->c($i)) % $this->getLength();
            if ($this->array[$probe]->state == self::_EMPTY)
                break;
            if ($this->array[$probe]->state == self::OCCUPIED
                && eq($obj, $this->array[$probe]->object))
            {
                return $probe;
            }
        }
        return -1;
    }

    /**
     * Finds an object in this open scatter table
     * that matches the specified object.
     *
     * @param object IComparable $obj The object to match.
     * @return mixed The object in this open scatter table
     * that matches the specified object; NULL if no match.
     */
    public function find(IComparable $obj)
    {
        $offset = $this->findMatch($obj);
        if ($offset >= 0)
            return $this->array[$offset]->object;
        else
            return NULL;
    }
//}>d

    /**
     * Finds the position of the specified object in this open scatter table.
     *
     * @param object IComparable $obj The object for which to look.
     * @return integer The position of the specified object;
     * -1 if it is not in the table.
     */
    protected function findInstance(IComparable $obj)
    {
        $hash = $this->h($obj);
        for ($i = 0; $i < $this->getLength(); ++$i)
        {
            $probe = ($hash + $this->c($i)) % $this->getLength();
            if ($this->array[$probe]->state == self::_EMPTY)
            {
                break;
            }
            if ($this->array[$probe]->state == self::OCCUPIED
                && $obj === $this->array[$probe]->object)
            {
                return $probe;
            }
        }
        return -1;
    }

//{
    /**
     * Withdraws the specified object from this open scatter table.
     *
     * @param object IComparable $obj The object to be withdrawn.
     */
    public function withdraw(IComparable $obj)
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        $offset = $this->findInstance($obj);
        if ($offset < 0)
            throw new ArgumentError();
        $this->array[$offset]->state = self::DELETED;
        $this->array[$offset]->object = NULL;
        --$this->count;
    }
//}>e

    /**
     * Tests whether the specified object is contained
     * in this open scatter table.
     *
     * @param object IComparable $obj The object for which to look.
     * @return boolean
     * True if the specified object is in this open scatter table;
     * false otherwise.
     */
    public function contains(IComparable $obj)
    {
        $offset = $this->findInstance($obj);
        if ($offset >= 0)
            return true;
        else
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
        return new OpenScatterTable_Iterator($this);
    }

    /**
     * Compares this open scatter table with the specified comparable object.
     * This method is not implemented.
     *
     * @param object IComparble $arg
     * The comparable object to which this open scatter table
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
        printf("OpenScatterTable main program.\n");
        $status = 0;
        $hashTable = new OpenScatterTable(57);
        AbstractHashTable::test($hashTable);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(OpenScatterTable::main(array_slice($argv, 1)));
}
?>
