<?php
/**
 * @copyright Copyright &copy; 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: OrderedListAsArray.php,v 1.13 2005/12/09 01:11:14 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractOrderedList.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/AbstractCursor.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * Represents a position in an OrderedListAsArray.
 *
 * @package Opus11
 */
class OrderedListAsArray_Cursor
    extends AbstractCursor
{
    /**
     * @var object OrderedListAsArray The ordered list.
     */
    protected $list = NULL;
    /**
     * @var integer The current offset.
     */
    protected $offset = 0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a OrderedListAsArray_Cursor
     * with the given list and offset.
     *
     * @param object OrderedListAsArray $list A list.
     * @param integer $offset The offset.
     */
    public function __construct(
        OrderedListAsArray $list, $offset = 0)
    {
        parent::__construct();
        $this->list = $list;
        $this->offset = $offset;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->list = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
    {
        return $this->offset < $this->list->getCount();
    }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
    {
        return $this->offset;
    }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        $array = $this->list->getArray();
        return $array[$this->offset];
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        $this->offset += 1;
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $this->offset = 0;
    }
//}>h

//{
    /**
     * Inserts the specified object in the ordered list
     * after this position.
     * @param object IObject $obj The object to insert.
     */
    public function insertAfter(IObject $obj)
    {
        if (!$this->valid())
            throw new IndexError();
        if ($this->list->isFull())
            throw new ContainerFullException();

        $insertPosition = $this->offset + 1;

        $array = $this->list->getArray();
            for ($i = $this->list->getCount();
                $i > $insertPosition; --$i)
                $array[$i] = $array[$i - 1];
            $array[$insertPosition] = $obj;
            $this->list->setCount($this->list->getCount() + 1);
        }
//}>f

    /**
     * Inserts the specified object in the ordered list
     * before this position.
     * @param object IObject $obj The object to insert.
     */
    public function insertBefore(IObject $obj)
    {
        if (!$this->valid())
            throw new IndexError();
        if ($this->list->isFull())
            throw new ContainerFullException();

        $insertPosition = $this->offset;

        $array = $this->list->getArray();
        for ($i = $this->list->getCount();
            $i > $insertPosition; --$i)
            $array[$i] = $array[$i - 1];
        $array[$insertPosition] = $obj;
        $this->list->setCount($this->list->getCount() + 1);
        $this->offset += 1;
    }

//{
    /**
     * Withdraws the object in the ordered list at this position.
     */
    public function withdraw()
    {
        if (!$this->valid())
            throw new IndexError();
        if ($this->list->getCount() == 0)
            throw new ContainerEmptyException();

        $i = $this->offset;
        $array = $this->list->getArray();
        while ($i < $this->list->getCount() - 1)
        {
            $array[$i] = $array[$i + 1];
            ++$i;
        }
        $array[$i] = NULL;
        $this->list->setCount($this->list->getCount() - 1);
    }
//}>g
}

//{
/**
 * Represents an ordered list implemented using an array.
 *
 * @package Opus11
 */
class OrderedListAsArray
    extends AbstractOrderedList
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
     * Constructs a OrderedListAsArray with the given size.
     *
     * @param integer size The size of this list.
     */
    public function __construct($size = 0)
    {
        parent::__construct();
        $this->array = new BasicArray($size);
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
     * @return object BasicArray A reference to the array of this list.
     */
    public function & getArray()
    {
        return $this->array;
    }

    /**
     * Count setter.
     *
     * @param integer $count The new count value.
     */
    public function setCount($count)
    {
        $this->count = $count;
    }
//}>a

//{
    /**
     * Inserts the specified object into this ordered list.
     * @param object IObject $obj The object to insert.
     */
    public function insert(IComparable $obj)
    {
        if ($this->count == $this->array->getLength())
            throw new ContainerFullException();
        $this->array[$this->count] = $obj;
        ++$this->count;
    }
//}>b

    /**
     * Purges this ordered list, making it empty.
     */
    public function purge()
    {
        while ($this->count > 0)
            $this->array[--$this->count] = NULL;
    }

    /**
     * Tests whether this ordered list is full.
     *
     * @return boolean True if this ordered list if full; false otherwise.
     */
    public function isFull()
    {
        return $this->count == $this->array->getLength();
    }

//{
    /**
     * Tests whether the specified object is in this ordered list.
     *
     * @param object IObject $obj The object for which to look.
     * @return boolean True if the specified object is in this list;
     * false otherwise.
     */
    public function contains(IComparable $obj)
    {
        for ($i = 0; $i < $this->count; ++$i)
            if ($this->array[$i] === $obj)
                return true;
        return false;
    }

    /**
     * Finds an object in this ordered list that matches the specified object.
     *
     * @param object IObject $obj The object to match.
     * @return mixed
     * The object in this list that matches the specified object;
     * NULL if no match is found.
     */
    public function find(IComparable $obj)
    {
        for ($i = 0; $i < $this->count; ++$i)
            if (eq($this->array[$i], $obj))
                return $this->array[$i];
        return NULL;
    }
//}>c

//{
    /**
     * Withdraws the given object from this ordered list.
     *
     * @param object IObject $obj The object to be withdrawn.
     */
    public function withdraw(IComparable $obj)
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        $i = 0;
        while ($i < $this->count && $this->array[$i] !== $obj)
            ++$i;
        if ($i == $this->count)
            throw new ArgumentError();
        for ( ; $i < $this->count - 1; ++$i)
            $this->array[$i] = $this->array[$i + 1];
        $this->array[$i] = NULL;
        $this->count -= 1;
    }
//}>d

//{
    /**
     * Returns the position of an object in this ordered list
     * that matches the specified object.
     *
     * @param object IObject $obj The object to match.
     * @return object ICursor The position in this list of the matching object.
     */
    public function findPosition(IComparable $obj)
    {
        $i = 0;
        while ($i < $this->count &&
            !eq($this->array[$i], $obj))
            ++$i;
        return new OrderedListAsArray_Cursor($this, $i);
    }

    /**
     * Returns true if the given offset exists.
     *
     * @param integer $offset An offset.
     */
    public function offsetExists($offset)
    {
        return $offset >= 0 && $offset < $this->count;
    }

    /**
     * Returns the object in this ordered lists
     * found at the specified offset.
     *
     * @param integer $offset The offset of the desired object.
     * @return object IComparable The object at the specified offset.
     */
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset))
            throw new IndexError();
        return $this->array[$offset];
    }
//}>e

    public function offsetSet($offset, $value)
    {
        throw new MethodNotImplementedException();
    }

    public function offsetUnset($offset)
    {
        throw new MethodNotImplementedException();
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
        for ($i = 0; $i < $this->count; ++$i)
        {
            $state = $callback($state, $this->array[$i]);
        }
        return $state;
    }

    /**
     * Returns an iterator that enumerates the objects in this list.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new OrderedListAsArray_Cursor($this);
    }

    /**
     * Compares this object with the given object.
     * This object and the given object are instances of the same class.
     *
     * @param object IComparable $obj The given object.
     * @return integer A number less than zero
     * if this object is less than the given object,
     * zero if this object equals the given object, and
     * a number greater than zero
     * if this object is greater than the given object.
     */
    public function compareTo(IComparable $obj)
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
        printf("OrderedListAsArray main program.\n");
        $status = 0;
        $list = new OrderedListAsArray(5);
        AbstractOrderedList::test($list);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(OrderedListAsArray::main(array_slice($argv, 1)));
}
?>
