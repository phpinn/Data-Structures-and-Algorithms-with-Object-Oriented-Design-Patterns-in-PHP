<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ChainedHashTable.php,v 1.7 2005/12/09 01:11:08 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractHashTable.php';
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/LinkedList.php';
require_once 'Opus11/Exceptions.php';

/**
 * An iterator that enumerates the items in a ChainedHashTable.
 *
 * @package Opus11
 */
class ChainedHashTable_Iterator
    extends AbstractIterator
{
    /**
     * @var object ChainedHashTable The hash table to enumerate.
     */
    protected $hashTable = NULL;
    /**
     * @var integer The offset.
     */
    protected $offset = 0;
    /**
     * @var object LinkedList_Element The element.
     */
    protected $element = NULL;
    /**
     * @var integer The key.
     */
    protected $key = 0;

    /**
     * Constructs a ChainedHashTable_Iterator for the given hash table.
     *
     * @param object ChainedHashTable $hashTable A hash table.
     */
    public function __construct(ChainedHashTable $hashTable)
    {
        parent::__construct();
        $this->hashTable = $hashTable;

        $this->element = NULL;
        $this->key = 0;
        $array = $this->hashTable->getArray();
        for ($this->offset = 0; $this->offset < $array->getLength();
            ++$this->offset)
        {
            $this->element = $array[$this->offset]->getHead();
            if ($this->element !== NULL)
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
        return $this->element !== NULL;
    }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        return $this->element->getDatum();
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        $this->element = $this->element->getNext();
        if ($this->element === NULL)
        {
            $array = $this->hashTable->getArray();
            for (++$this->offset; $this->offset < $array->getLength();
                ++$this->offset)
            {
                $this->element = $array[$this->offset]->getHead();
                if ($this->element !== NULL)
                    break;
            }
        }
        ++$this->key;
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $this->element = NULL;
        $this->key = 0;
        $array = $this->hashTable->getArray();
        for ($this->offset = 0; $this->offset < $array->getLength();
            ++$this->offset)
        {
            $this->element = $array[$this->offset]->getHead();
            if ($this->element !== NULL)
                break;
        }
    }
}

//{
/**
 * A chained hash table implemented using an array of linked lists.
 *
 * @package Opus11
 */
class ChainedHashTable
    extends AbstractHashTable
{
    /**
     * $var object BasicArray The array.
     */
    protected $array = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a ChainedHashTable with the given length.
     *
     * @param integer $length The length of this hash table.
     */
    public function __construct($length = 0)
    {
        parent::__construct();
        $this->array = new BasicArray($length);
        for ($i = 0; $i < $length; ++$i)
            $this->array[$i] = new LinkedList();
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
     * @return array A reference to the array of this hash table.
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

//{
    /**
     * Inserts the specified comparable object
     * into this chained hash table.
     *
     * @param object IComparable $obj The object to insert.
     */
    public function insert(IComparable $obj)
    {
        $this->array[$this->h($obj)]->append($obj);
        ++$this->count;
    }

    /**
     * Withdraws the specified comparable object
     * from this chained hash table.
     *
     * @param object IComparable $obj The object to withdraw.
     */
    public function withdraw(IComparable $obj)
    {
        $this->array[$this->h($obj)]->extract($obj);
        --$this->count;
    }
//}>c

    /**
     * Tests whether the specified object
     * is in this chained hash table.
     *
     * @param object IComparable $obj The object for which to look.
     * @return boolean True if the object is in this chained hash table;
     * false otherwise.
     */
    public function contains(IComparable $obj)
    {
        for ($ptr = $this->array[$this->h($obj)]->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            $datum = $ptr->getDatum();
            if (eq($obj, $datum))
                return true;
        }
        return false;
    }

//{
    /**
     * Returns an object in this chained hash table
     * that matches the specified comparable object.
     *
     * @param object IComparable $obj The object to match.
     * @return mixed The object in this chained hash table
     * that matches the specified object;
     * NULL if there is no match.
     */
    public function find(IComparable $obj)
    {
        for ($ptr = $this->array[$this->h($obj)]->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            $datum = $ptr->getDatum();
            if (eq($obj, $datum))
                return $datum;
        }
        return NULL;
    }
//}>d

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
            for ($ptr = $this->array[$i]->getHead();
                $ptr !== NULL; $ptr = $ptr->getNext())
            {
                $state = $callback($state, $ptr->getDatum());
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
        return new ChainedHashTable_Iterator($this);
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
        printf("ChainedHashTable main program.\n");
        $status = 0;
        $hashTable = new ChainedHashTable(57);
        AbstractHashTable::test($hashTable);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(ChainedHashTable::main(array_slice($argv, 1)));
}
?>
