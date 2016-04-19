<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: QueueAsArray.php,v 1.10 2005/12/09 01:11:15 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractQueue.php';
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * An iterator that enumerates the items in a QueueAsArray.
 *
 * @package Opus11
 */
class QueueAsArray_Iterator
    extends AbstractIterator
{
    /**
     * @var object QueueAsArray The queue to enumerate.
     */
    protected $queue = NULL;
    /**
     * @var integer The current position.
     */
    protected $position = 0;
    /**
     * @var integer The number of objects enuemrated.
     */
    protected $count = 0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a QueueAsArray_Iterator for the given queue.
     *
     * @param object QueueAsArray $queue A queue.
     */
    public function __construct(QueueAsArray $queue)
    {
        parent::__construct();
        $this->queue = $queue;
        $this->position = $this->queue->getHeadPosition();
        $this->count = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->queue = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
        { return $this->count < $this->queue->getCount(); }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
        { return $this->count; }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        $array = $this->queue->getArray();
        return $array[$this->position];
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next() {
        if (++$this->position ==
            $this->queue->getArray()->getLength())
            $this->position = 0;
        $this->count += 1;
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $this->position = $this->queue->getHeadPosition();
        $this->count = 0;
    }
//}>f
}

//{
/**
 * Represents a queue implemented using an array.
 *
 * @package Opus11
 */
class QueueAsArray
    extends AbstractQueue
{
    /**
     * @var object BasicArray The array.
     */
    protected $array = NULL;
    /**
     * @var integer The position of the head of the queue.
     */
    protected $head = 0;
    /**
     * @var integer The position of the tail of the queue.
     */
    protected $tail = 0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a QueueAsArray with the given size.
     *
     * @param integer $size The size of this queue.
     */
    public function __construct($size = 0)
    {
        parent::__construct();
        $this->array = new BasicArray($size);
        $this->head = 0;
        $this->tail = $size - 1;
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
     * @return object BasicArray A reference to the array of this queue.
     */
    public function & getArray()
    {
        return $this->array;
    }

    /**
     * Head position getter.
     */
    public function getHeadPosition()
    {
        return $this->head;
    }

    /**
     * Tail position getter.
     */
    public function getTailPosition()
    {
        return $this->tail;
    }
//}>a

//{
    /**
     * Purges this queue.
     */
    public function purge()
    {
        while ($this->count > 0)
        {
            $this->array[$this->head] = NULL;
            if (++$this->head == $this->array->getLength())
                $this->head = 0;
            $this->count -= 1;
        }
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
        if ($this->count == $this->array->getLength())
            throw new ContainerFullException();
        if (++$this->tail == $this->array->getLength())
            $this->tail = 0;
        $this->array[$this->tail] = $obj;
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
        $result = $this->array[$this->head];
        $this->array[$this->head] = NULL;
        if (++$this->head == $this->array->getLength())
            $this->head = 0;
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
        return $this->array[$this->head];
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
        $pos = $this->head;
        $state = $initialState;
        for ($i = 0; $i < $this->count; ++$i)
        {
            $state = $callback($state, $this->array[$pos]);
            if (++$pos == $this->array->getLength())
                $pos = 0;
        }
        return $state;
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
        return new QueueAsArray_Iterator($this);
    }
//}>e

    /**
     * IsFull predicate.
     *
     * @return boolean True if this queue is full.
     */
    public function isFull()
    {
        return $this->count == $this->array->getLength();
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
        printf("QueueAsArray main program.\n");
        $status = 0;
        $queue = new QueueAsArray(5);
        AbstractQueue::test($queue);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(QueueAsArray::main(array_slice($argv, 1)));
}
?>
