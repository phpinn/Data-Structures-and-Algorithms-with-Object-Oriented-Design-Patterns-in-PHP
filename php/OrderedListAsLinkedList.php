<?php
/**
 * @copyright Copyright &copy; 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: OrderedListAsLinkedList.php,v 1.12 2005/12/09 01:11:14 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractOrderedList.php';
require_once 'Opus11/LinkedList.php';
require_once 'Opus11/AbstractCursor.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * Represents a position in an OrderedListAsLinkedList.
 *
 * @package Opus11
 */
class OrderedListAsLinkedList_Cursor
    extends AbstractCursor
{
    /**
     * @var object OrderedListAsLinkedList The ordered list.
     */
    protected $list = NULL;
    /**
     * @var object LinkedList_Element The current element.
     */
    protected $element = NULL;
    /**
     * @var integer The current key.
     */
    protected $key = 0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a OrderedListAsLinkedList_Cursor
     * with the given list, element and key.
     *
     * @param object OrderedListAsLinkedList $list A list.
     * @param mixed $element A list element.
     * @param mixed $key The key for the given element.
     */
    public function __construct(
        OrderedListAsLinkedList $list, $element = NULL, $key = 0)
    {
        parent::__construct();
        $this->list = $list;
        $this->element = $element;
        $this->key = $key;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->list = NULL;
        $this->element = NULL;
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
//}>h

//{
    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        $this->element = $this->element->getNext();
        $this->key += 1;
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $this->element = $this->list->getList()->getHead();
        $this->key = 0;
    }
//}>i

//{
    /**
     * Inserts the specified object in the ordered list
     * after this position.
     * @param object IObject $obj The object to insert.
     */
    public function insertAfter(IObject $obj)
    {
        $this->element->insertAfter($obj);
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
        $this->element->insertBefore($obj);
        $this->list->setCount($this->list->getCount() + 1);
    }

//{
    /**
     * Withdraws the object in the ordered list at this position.
     */
    public function withdraw()
    {
        $this->list->getList()->extract(
            $this->element->getDatum());
        $this->list->setCount($this->list->getCount() - 1);
    }
//}>g
}

//{
/**
 * Represents an ordered list implemented using a linked list.
 *
 * @package Opus11
 */
class OrderedListAsLinkedList
    extends AbstractOrderedList
{
    /**
     * @var object LinkedList The linked list.
     */
    protected $list = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a OrderedListAsLinkedList with the given size.
     */
    public function __construct()
    {
        parent::__construct();
        $this->list = new LinkedList();
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
     * Array getter.
     *
     * @return object LinkedList A reference to the linked list of this list.
     */
    public function & getList()
    {
        return $this->list;
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
     * @param object IComparable $obj The object to insert.
     */
    public function insert(IComparable $obj)
    {
        $this->list->append($obj);
        ++$this->count;
    }
//}>b

    /**
     * Purges this ordered list, making it empty.
     */
    public function purge()
    {
        $this->list = new LinkedList();
        $this->count = 0;
    }

//{
    /**
     * Tests whether the specified object is in this ordered list.
     *
     * @param object IComparable $obj The object for which to look.
     * @return boolean True if the specified object is in this list;
     * false otherwise.
     */
    public function contains(IComparable $obj)
    {
        for ($ptr = $this->list->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            if ($ptr->getDatum() === $obj)
                return true;
        }
        return false;
    }

    /**
     * Finds an object in this ordered list that matches the specified object.
     * @param object IComparable $obj The object to match.
     * @return mixed
     * The object in this list that matches the specified object;
     * NULL if no match is found.
     */
    public function find(IComparable $obj)
    {
        for ($ptr = $this->list->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            if (eq($ptr->getDatum(), $obj))
                return $ptr->getDatum();
        }
        return NULL;
    }
//}>c

//{
    /**
     * Withdraws the given object from this ordered list.
     *
     * @param object IComparable $obj The object to be withdrawn.
     */
    public function withdraw(IComparable $obj)
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        $this->list->extract($obj);
        $this->count -= 1;
    }
//}>d

//{
    /**
     * Returns the position of an object in this ordered list
     * that matches the specified object.
     *
     * @param object IComparable $obj The object to match.
     * @return object ICursor The position in this list of the matching object.
     */
    public function findPosition(IComparable $obj)
    {
        $ptr = $this->list->getHead();
        $key = 0;
        while ($ptr !== NULL)
        {
            if (eq($ptr->getDatum(), $obj))
                break;
            $ptr = $ptr->getNext();
            ++$key;
        }
        return new OrderedListAsLinkedList_Cursor(
            $this, $ptr, $key);
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
        $ptr = $this->list->getHead();
        for ($i = 0; $i < $offset; ++$i)
            $ptr = $ptr->getNext();
        return $ptr->getDatum();
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
     * @param mixed $initialState The initial value.
     * @return mixed The value returned by
     * the last call to the callback function.
     */
    public function reduce($callback, $initialState)
    {
        $state = $initialState;
        for ($ptr = $this->list->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            $state = $callback($state, $ptr->getDatum());
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
        return new OrderedListAsLinkedList_Cursor(
            $this, $this->list->getHead(), 0);
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
        printf("OrderedListAsLinkedList main program.\n");
        $status = 0;
        $list = new OrderedListAsLinkedList(5);
        AbstractOrderedList::test($list);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(OrderedListAsLinkedList::main(array_slice($argv, 1)));
}
?>
