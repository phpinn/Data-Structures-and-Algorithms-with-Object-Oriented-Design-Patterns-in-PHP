<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Deap.php,v 1.4 2005/12/09 01:11:09 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractDoubleEndedPriorityQueue.php';
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/Exceptions.php';

/**
 * An iterator that enumerates the items in a Deap.
 *
 * @package Opus11
 */
class Deap_Iterator
    extends AbstractIterator
{
    /**
     * @var object Deap The heap to enumerate.
     */
    protected $heap = NULL;
    /**
     * @var integer The current position.
     */
    protected $position = 0;

    /**
     * Constructs a Deap_Iterator for the given queue.
     *
     * @param object Deap $heap A heap.
     */
    public function __construct(Deap $heap)
    {
        parent::__construct();
        $this->heap = $heap;
        $this->position = 0;
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
        { return $this->position < $this->heap->getCount(); }

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
        return $array[$this->position + 2];
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
        { $this->position = 0; }
}

/**
 * A double-ended priority queue implemented as a binary heap.
 *
 * @package Opus11
 */
class Deap
    extends AbstractDoubleEndedPriorityQueue
{
    /**
     * @var object BasicArray The heap.
     */
    protected $array = NULL;

    /**
     * Constructs a Deap with the given size.
     *
     * @param integer $size The size of this queue.
     */
    public function __construct($size = 0)
    {
        parent::__construct();
        $this->array = new BasicArray($size, 2);
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
     * Purges this deap, making it empty.
     */
    public function purge()
    {
        $this->array = new BasicArray($this->array->getLength(), 2);
        $this->count = 0;
    }

    /**
     * Returns the floor of the logarithm to the base two of the
     * specified integer.
     *
     * @param integer $i The specified integer.
     * @return integer The floor of the logarithm to the base two of the
     * specified integer.
     */
    private static function log2($i)
    {
        $result = 0;
        while ((1 << $result) <= $i)
            ++$result;
        return $result - 1;
    }

    /**
     * Returns two raised to the power n-1,
     * where n is the floor of
     * the logarithm to the base two of the specified integer.
     *
     * @param integer $i The specified integer.
     * @return integer Two raised to the power n-1,
     * where n is the floor of
     * the logarithm to the base two of the specified integer.
     */
    private static function mask($i)
    {
        return 1 << (self::log2($i) - 1);
    }

    /**
     * Returns the position in this deap
     * of the dual of the object at the specified position.
     *
     * @param integer $i The specified position.
     * @return integer The position in this deap
     * of the dual of the object at the specified position.
     */
    protected function dual($i)
    {
        $m = self::mask($i);
        $result = $i ^ $m;

        if (($result & $m) != 0)
        {
            if ($result >= $this->count + 2)
                $result = intval($result/2);
        }
        else
        {
            if (2 * $result < $this->count + 2)
            {
                $result *= 2;
                if ($result + 1 < $this->count + 2
                    && gt($this->array[$result + 1], $this->array[$result]))
                    $result += 1;
            }
        }
        return $result;
    }

    /**
     * Returns the "smallest" object in this deap.
     * The smallest object in this deap is the object
     * which is less than or equal to all other objects in this deap.
     *
     * @return object IComparable The "smallest" object in this deap.
     */
    public function findMin()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        return $this->array[2];
    }

    /**
     * Returns the "largest" object in this deap.
     * The largest object in this deap is the object
     * which is greater than or equal to all other objects in this deap.
     *
     * @return object IComparable The "largest" object in this deap.
     */
    public function findMax()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        if ($this->count == 1)
            return $this->array[2];
        else
            return $this->array[3];
    }

    /**
     * Inserts the specified object starting at the specified position
     * in the min-heap side of this deap.
     *
     * @param integer $pos The position at which to start.
     * @param object IComparable $obj The object to insert.
     */
    protected function insertMin($pos, IComparable $obj)
    {
        $i = $pos;
        while ($i > 2 && gt($this->array[intval($i/2)], $obj))
        {
            $this->array[$i] = $this->array[intval($i/2)];
            $i = intval($i/2);
        }
        $this->array[$i] = $obj;
    }

    /**
     * Inserts the specified object starting at the specified position
     * in the max-heap side of this deap.
     *
     * @param integer $pos The position at which to start.
     * @param object IComparable $obj The object to insert.
     */
    protected function insertMax($pos, IComparable $obj)
    {
        $i = $pos;
        while ($i > 3 && lt($this->array[intval($i/2)], $obj))
        {
            $this->array[$i] = $this->array[intval($i/2)];
            $i = intval($i/2);
        }
        $this->array[$i] = $obj;
    }

    /**
     * Inserts the specified object into this deap.
     *
     * @param object IComparable $obj The object to insert.
     */
    public function enqueue(IComparable $obj)
    {
        if ($this->count == $this->array->getLength())
            throw new ContainerFullException();
        if (++$this->count == 1)
            $this->array[2] = $obj;
        else
        {
            $i = $this->count + 1;
            $j = $this->dual($i);
            if (($i & self::mask($i)) != 0)
            {
                if (ge($obj, $this->array[$j]))
                    $this->insertMax($i, $obj);
                else
                {
                    $this->array[$i] = $this->array[$j];
                    $this->insertMin($j, $obj);
                }
            }
            else
            {
                if (lt($obj, $this->array[$j]))
                    $this->insertMin($i, $obj);
                else
                {
                    $this->array[$i] = $this->array[$j];
                    $this->insertMax($j, $obj);
                }
            }
        }
    }

    /**
     * Dequeues and returns the "smallest" object in this deap.
     * The smallest object in this deap is the object
     * which is less than or equal to all other objects in this deap.
     *
     * @return object IComparable The "smallest" object in this deap.
     */
    public function dequeueMin()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        $result = $this->array[2];
        $last = $this->array[$this->count + 1];
        --$this->count;
        if ($this->count <= 1)
            $this->array[2] = $last;
        else
        {
            $i = 2;
            while (2 * $i < $this->count + 2)
            {
                $child = 2 * $i;
                if ($child + 1 < $this->count + 2
                    && lt($this->array[$child + 1], $this->array[$child]))
                    $child += 1;
                $this->array[$i] = $this->array[$child];
                $i = $child;
            }
            $j = $this->dual($i);
            if (le($last, $this->array[$j]))
                $this->insertMin($i, $last);
            else
            {
                $this->array[$i] = $this->array[$j];
                $this->insertMax($j, $last);
            }
        }
        return $result;
    }

    /**
     * Dequeues and returns the "largest" object in this deap.
     * The largest object in this deap is the object
     * which is larger than or equal to all other objects in this deap.
     *
     * @return object IComparable The "largest" object in this deap.
     */
    public function dequeueMax()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        if ($this->count == 1)
        {
            --$this->count;
            return $this->array[2];
        }
        elseif ($this->count == 2)
        {
            --$this->count;
            return $this->array[3];
        }
        else
        {
            $result = $this->array[3];
            $last = $this->array[$this->count + 1];
            --$this->count;
            $i = 3;
            while (2 * $i < $this->count + 2)
            {
                $child = 2 * $i;
                if ($child + 1 < $this->count + 2
                    && gt($this->array[$child + 1], $this->array[$child]))
                    $child += 1;
                $this->array[$i] = $this->array[$child];
                $i = $child;
            }
            $j = $this->dual($i);
            if (ge($last, $this->array[$j]))
                $this->insertMax($i, $last);
            else
            {
                $this->array[$i] = $this->array[$j];
                $this->insertMin($j, $last);
            }
            return $result;
        }
    }

    /**
     * Tests whether this deap is full.
     *
     * @return boolean True if this deap is full; false otherwise.
     */
    public function isFull()
    {
        return $this->count == $this->array->getLength() - 2;
    }

    /**
     * Accepts the specified visitor and makes it visit all the objects
     * in this deap.
     *
     * @param object IVisitor $visitor The visitor to accept.
     */
    public function accept(IVisitor $visitor)
    {
        for ($i = 2; $i < $this->count + 2; ++$i)
        {
            if ($visitor->isDone())
                return;
            $visitor->visit($this->array[$i]);
        }
    }

    /**
     * Returns an iterator that enumerates all the objects in this deap.
     *
     * @return object Iterator An iterator.
    **/
    public function getIterator()
    {
        return new Deap_Iterator($this);
    }

    /**
     * Compares this deap with the specified comparable object.
     * This method is not implemented.
     *
     * @param object IComparable $arg
     * The comparable object with which to compare this deap.
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
        printf("Deap main program.\n");
        $status = 0;
        $queue = new Deap(57);
        AbstractDoubleEndedPriorityQueue::test($queue);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Deap::main(array_slice($argv, 1)));
}
?>
