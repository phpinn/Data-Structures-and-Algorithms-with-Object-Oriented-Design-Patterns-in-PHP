<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: StackAsLinkedList.php,v 1.13 2005/12/09 01:11:17 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractStack.php';
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/LinkedList.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * An iterator that enumerates the items in a StackAsLinkedList.
 *
 * @package Opus11
 */
class StackAsLinkedList_Iterator
    extends AbstractIterator
{
    /**
     * @var object StackAsLinkedList The stack to enumerate.
     */
    protected $stack = NULL;
    /**
     * @var object LinkedList_Element The current position.
     */
    protected $position = NULL;
    /**
     * @var integer The key for the current position.
     */
    protected $key = 0;

//}@head

//{
//!}
//}@tail

//{
    /**
     * Constructs a StackAsLinkedList_Iterator for the given stack.
     *
     * @param object StackAsLinkedList $stack A stack.
     */
    public function __construct(StackAsLinkedList $stack)
    {
        parent::__construct();
        $this->stack = $stack;
        $this->position = $stack->getList()->getHead();
        $this->key = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->stack = NULL;
        $this->position = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
        { return $this->position !== NULL; }

    /**
     * Key getter.
     *
     * @return integer The key at the current position of this iterator.
     */
    public function key()
        { return $this->key; }

    /**
     * Current getter.
     *
     * @return mixed The value at the current position of this iterator.
     */
    public function current()
        { return $this->position->getDatum(); }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        $this->position = $this->position->getNext();
        $this->key += 1;
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $this->position = $this->stack->getList()->getHead();
        $this->key = 0;
    }
//}>f
}

//{
/**
 * Represents a stack implemented using a linked list.
 *
 * @package Opus11
 */
class StackAsLinkedList
    extends AbstractStack
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
     * Constructs a StackAsLinkedList.
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
     * List getter.
     *
     * @return object LinkedList The linked list of this stack.
     */
    public function getList()
    {
        return $this->list;
    }
//}>a

//{
    /**
     * Purges this stack.
     */
    public function purge()
    {
        $this->list->purge();
        parent::purge();
    }
//}>b

//{
    /**
     * Pushes the given object on to this stack.
     *
     * @param object IObject $obj The object to push.
     */
    public function push(IObject $obj)
    {
        $this->list->prepend($obj);
        $this->count += 1;
    }

    /**
     * Pops and returns the top object on this stack.
     *
     * @return object IObject The top object on this stack.
     */
    public function pop()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        $result = $this->list->getFirst();
        $this->list->extract($result);
        $this->count -= 1;
        return $result;
    }

    /**
     * Top getter.
     *
     * @return object IObject The top object on this stack.
     */
    public function getTop()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        return $this->list->getFirst();
    }
//}>c

//{
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
        return $this->list->reduce($callback, $initialState);
    }
//}>d

//{
    /**
     * Returns an iterator that enumerates the objects in this stack.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new StackAsLinkedList_Iterator($this);
    }
//}>e

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
        printf("StackAsLinkedList main program.\n");
        $status = 0;
        $stack = new StackAsLinkedList();
        AbstractStack::test($stack);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(StackAsLinkedList::main(array_slice($argv, 1)));
}
?>
