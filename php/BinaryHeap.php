<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: BinaryHeap.php,v 1.6 2005/12/09 01:11:07 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractPriorityQueue.php';
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * An iterator that enumerates the items in a BinaryHeap.
 *
 * @package Opus11
 */
class BinaryHeap_Iterator
    extends AbstractIterator
{
    /**
     * The heap to enumerate.
     */
    protected $heap = NULL;
    /**
     * The current position.
     */
    protected $position = 0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a BinaryHeap_Iterator for the given queue.
     *
     * @param object BinaryHeap $heap A heap.
     */
    public function __construct(BinaryHeap $heap)
    {
        parent::__construct();
        $this->heap = $heap;
        $this->position = 1;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->heap = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
        { return $this->position <= $this->heap->getCount(); }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
        { return $this->position; }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        $array = $this->heap->getArray();
        return $array[$this->position];
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
        { $this->position += 1; }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
        { $this->position = 1; }
//}>f
}

//{
/**
 * A priority queue implemented as a binary heap.
 *
 * @package Opus11
 */
class BinaryHeap
    extends AbstractPriorityQueue
{
    /**
     * The array.
     */
    protected $array = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a BinaryHeap with the given size.
     *
     * @param integer $size The size of this queue.
     */
    public function __construct($size = 0)
    {
        parent::__construct();
        $this->array = new BasicArray($size, 1);
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
     * @return array A reference to the array of this queue.
     */
    public function & getArray()
    {
        return $this->array;
    }

    /**
    * Purges the heap, making it empty.
    **/
    public function purge()
    {
        while ($this->count > 0)
            $this->array[$this->count--] = NULL;
    }
//}>a

//{
    /**
     * Enqueues the specified object.
     *
     * @param object IComparable $obj The object to enqueue.
     */
    public function enqueue(IComparable $obj)
    {
        if ($this->count == $this->array->getLength())
            throw new ContainerFullException();
        ++$this->count;
        $i = $this->count;
        while ($i > 1 && gt($this->array[intval($i/2)], $obj))
        {
            $this->array[$i] = $this->array[intval($i/2)];
            $i = intval($i/2);
        }
        $this->array[$i] = $obj;
    }
//}>c

//{
    /**
     * Returns the "smallest" object in this heap.
     * The smallest element is the object in this heap
     * that is less than or equal to all other objects in this heap.
     *
     * @return object IObject The "smallest" object in this heap.
     */
    public function findMin()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        return $this->array[1];
    }
//}>d

//{
    /**
     * Dequeues and returns the "smallest" object in this heap.
     * The smallest element is the object in this heap
     * that is less than or equal to all other objects in this heap.
     *
     * @return object IObject The "smallest" object in this heap.
     */
    public function dequeueMin()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        $result = $this->array[1];
        $last = $this->array[$this->count];
        --$this->count;
        $i = 1;
        while (2 * $i < $this->count + 1)
        {
            $child = 2 * $i;
            if ($child + 1 < $this->count + 1 &&
                lt($this->array[$child+1], $this->array[$child]))
                $child += 1;
            if (le($last, $this->array[$child]))
                break;
            $this->array[$i] = $this->array[$child];
            $i = $child;
        }
        $this->array[$i] = $last;
        return $result;
    }
//}>e

    /**
     * Tests whether this heap is full.
     *
     * @return boolean True if this heap is full; false otherwise.
     */
    public function isFull ()
        { return $this->count == $this->array->getLength(); }

    /**
     * Accepts the specified visitor and makes it visit
     * all the objects in this heap.
     *
     * @param object IVisitor $visitor The visitor to accept.
     */
    public function accept(IVisitor $visitor)
    {
        for ($i = 1; $i < $this->count + 1; ++$i)
        {
            if ($visitor->isDone())
                return;
            $visitor->visit($this->array[$i]);
        }
    }

    /**
     * Returns an enumeration that enumerates all the objects in this heap.
     *
     * @return object BinaryHeap_Iterator
     * An enumeration that enumerates all the objects in this heap.
     */
    public function getIterator ()
    {
        return new BinaryHeap_Iterator($this);
    }

    /**
     * Compares this heap with the specified comparable object.
     * This method is not implemented.
     * @param object IComparable $arg
     * The comparable object with which to compare this heap.
     * @exception MethodNotImplemented Always.
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
        printf("BinaryHeap main program.\n");
        $status = 0;
        $queue = new BinaryHeap(57);
        AbstractPriorityQueue::test($queue);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(BinaryHeap::main(array_slice($argv, 1)));
}
?>
