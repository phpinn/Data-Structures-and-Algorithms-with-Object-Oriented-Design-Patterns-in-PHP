<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: QueueAsLinkedList.php,v 1.10 2005/12/09 01:11:15 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractQueue.php';
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/LinkedList.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * An iterator that enumerates the items in a QueueAsLinkedList.
 *
 * @package Opus11
 */
class QueueAsLinkedList_Iterator
    extends AbstractIterator
{
    /**
     * @var object QueueAsLinkedList The queue to enumerate.
     */
    protected $queue = NULL;
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
     * Constructs a QueueAsLinkedList_Iterator for the given queue.
     *
     * @param object QueueAsLinkedList $queue A queue.
     */
    public function __construct(QueueAsLinkedList $queue)
    {
        parent::__construct();
        $this->queue = $queue;
        $this->position = $queue->getList()->getHead();
        $this->key = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
        $this->queue = NULL;
        $this->position = NULL;
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
        $this->position = $this->queue->getList()->getHead();
        $this->key = 0;
    }
//}>f
}

//{
/**
 * Represents a queue implemented using a linked list.
 *
 * @package Opus11
 */
class QueueAsLinkedList
    extends AbstractQueue
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
     * Constructs a QueueAsLinkedList.
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
     * @return object LinkedList The linked list of this queue.
     */
    public function getList()
    {
        return $this->list;
    }
//}>a

//{
    /**
     * Purges this queue.
     */
    public function purge()
    {
        $this->list->purge();
    }
//}>b

//{
    /**
     * Enqueues the given object at the tail of this queue.
     *
     * @param object IObject $obj The object to enqueue.
     */
    public function enqueue(IObject $obj)
    {
        $this->list->append($obj);
        $this->count += 1;
    }

    /**
     * Dequeues and returns the object at the head of this queue.
     *
     * @return object IObject The object at the head of this queue.
     */
    public function dequeue()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        $result = $this->list->getFirst();
        $this->list->extract($result);
        $this->count -= 1;
        return $result;
    }

    /**
     * Head getter.
     *
     * @return object IObject The object at the head of this queue.
     */
    public function getHead()
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
     * Returns an iterator that enumerates the objects in this queue.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new QueueAsLinkedList_Iterator($this);
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
        printf("QueueAsLinkedList main program.\n");
        $status = 0;
        $queue = new QueueAsLinkedList();
        AbstractQueue::test($queue);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(QueueAsLinkedList::main(array_slice($argv, 1)));
}
?>
