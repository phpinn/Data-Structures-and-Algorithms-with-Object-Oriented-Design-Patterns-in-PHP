<?php
/**
 * @copyright Copyright &copy; 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: MultisetAsArray.php,v 1.3 2005/12/09 01:11:14 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractMultiset.php';
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/Exceptions.php';

/**
 * An iterator that enumerates the items in a MultisetAsArray.
 *
 * @package Opus11
 */
class MultisetAsArray_Iterator
    extends AbstractIterator
{
    /**
     * @var object MultisetAsArray The set to enumerate.
     */
    protected $set = NULL;
    /**
     * @var integer The current item.
     */
    protected $item = 0;
    /**
     * @var integer The current count.
     */
    protected $count = 0;
    /**
     * @var integer The current position.
     */
    protected $position = 0;

    /**
     * Constructs a MultisetAsArray_Iterator for the given set.
     *
     * @param object MultisetAsArray $set A set.
     */
    public function __construct(MultisetAsArray $set)
    {
        parent::__construct();
        $this->set = $set;
        $this->item = 0;
        $array = $this->set->getArray();
        while ($this->item < $this->set->getUniverseSize() &&
            $array[$this->item] == 0)
            ++$this->item;
        $this->count = 0;
        $this->position = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->set = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
        { return $this->item < $this->set->getUniverseSize(); }

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
        { return $this->item; }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        ++$this->count;
        $array = $this->set->getArray();
        if ($this->count >= $array[$this->item])
        {
            ++$this->item;
            $array = $this->set->getArray();
            while ($this->item < $this->set->getUniverseSize() &&
                $array[$this->item] == 0)
                ++$this->item;
            $this->count = 0;
        }
        ++$this->position;
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $this->item = 0;
        $array = $this->set->getArray();
        while ($this->item < $this->set->getUniverseSize() &&
            $array[$this->item] == 0)
            ++$this->item;
        $this->count = 0;
        $this->position = 0;
    }
}

//{
/**
 * Multiset implemented using an array of counters.
 *
 * @package Opus11
 */
class MultisetAsArray
    extends AbstractMultiset
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
     * Constructs a MultisetAsArray for the specified size
     * of universal set.
     *
     * @param integer $n The number of elements in the universal set.
     */
    public function __construct($n = 0)
    {
        parent::__construct($n);
        $this->array = new BasicArray($n);
        for ($item = 0; $item < $this->universeSize; ++$item)
            $this->array[$item] = 0;
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
     * @return object BasicArray The array of this multiset.
     */
    public function & getArray()
    {
        return $this->array;
    }
//}>a

//{
    /**
     * Inserts the specified item into this set.
     *
     * @param integer $item The item to insert.
     */
    public function insertItem($item)
    {
        $this->array[$item] += 1;
    }

    /**
     * Tests if the specified item is a member of this set.
     *
     * @param integer $item The item for which to look.
     * @return boolean True if the item is a member of this set;
     * false otherwise.
     */
    public function containsItem($item)
    {
        return $this->array[$item] > 0;
    }

    /**
     * Withdraws the specified item from this set.
     *
     * @param integer $item The item to be withdrawn.
     */
    public function withdrawItem($item)
    {
        if ($this->array[$item] > 0)
            $this->array[$item] -= 1;
    }
//}>b

    /**
     * Purges this set, making it empty.
     */
    public function purge()
    {
        for ($item = 0; $item < $this->universeSize; ++$item)
            $this->array[$item] = 0;
    }

    /**
     * Counter getter.
     *
     * @return integer The number of items in this multiset.
     */
    public function getCount()
    {
        $result = 0;
        for ($item = 0; $item < $this->universeSize; ++$item)
            $result += $this->array[$item];
        return $result;
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
     * @param mixed initialState The initial state.
     * @return mixed The value returned by
     * the last call to the callback function.
     */
    public function reduce($callback, $initialState)
    {
        $state = $initialState;
        for ($item = 0; $item < $this->universeSize; ++$item)
        {
            for ($i = 0; $i < $this->array[$item]; ++$i)
            {
                $state = $callback($state, box($item));
            }
        }
        return $state;
    }

//{
    /**
     * Returns a set which is the union of this set
     * and the specified set.
     * It is assumed that the specified set is an instance of
     * the MultisetAsArray class.
     *
     * @param object IMultiset $set The set to join with this set.
     * @return object IMultiset The union of this set with the specified set.
     */
    public function union(IMultiset $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        $result = new MultisetAsArray($this->universeSize);
        for ($i = 0; $i < $this->universeSize; ++$i)
            $result->array[$i] =
                $this->array[$i] + $set->array[$i];
        return $result;
    }

    /**
     * Returns a set which is the intersection of this set
     * and the specified set.
     * It is assumed that the specified set is an instance of
     * the MultisetAsArray class.
     *
     * @param object IMultiset $set The set to intersect with this set.
     * @return object IMultiset
     * The intersection of this set with the specified set.
     */
    public function intersection(IMultiset $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        $result = new MultisetAsArray($this->universeSize);
        for ($i = 0; $i < $this->universeSize; ++$i)
            $result->array[$i] =
                min($this->array[$i], $set->array[$i]);
        return $result;
    }

    /**
     * Returns a set which is the difference between this set
     * and the specified set.
     * It is assumed that the specified set is an instance of
     * the MultisetAsArray class.
     *
     * @param object IMultiset $set The set to subtract from this set.
     * @return object IMultiset 
     * The difference between this set and the specified set.
     */
    public function difference(IMultiset $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        $result = new MultisetAsArray($this->universeSize);
        for ($i = 0; $i < $this->universeSize; ++$i)
            if ($set->array[$i] <= $this->array[$i])
                $result->array[$i] =
                    $this->array[$i] - $set->array[$i];
        return $result;
    }
//}>c

//{
    /**
     * Tests whether this set is equal to the specified set.
     * It is assumed that the specified set is an instance of
     * the MultisetAsArray class.
     *
     * @param object IMultiset $set The set to compare with this set.
     * @return boolean True if the sets are equal; false otherwise.
     */
    public function eq(IComparable $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        for ($item = 0; $item < $this->universeSize; ++$item)
            if ($this->array[$item] != $set->array[$item])
                return false;
        return true;
    }

    /**
     * Tests whether this set is a subset of the specified set.
     * It is assumed that the specified set is an instance of
     * the MultisetAsArray class.
     *
     * @param object IMultiset $set The set to compare with this set.
     * @return boolean True if the this set is a subset of the specified set;
     * false otherwise.
     */
    public function isSubset(IMultiset $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        for ($item = 0; $item < $this->universeSize; ++$item)
            if ($this->array[$item] <= $set->array[$item])
                return false;
        return true;
    }
//}>d

    /**
     * Returns an iterator the enumerates the elements of this multiset.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new MultisetAsArray_Iterator($this);
    }

    /**
     * Compares this set with the specified comparable object.
     * This method is not implemented.
     *
     * @param object IComparable $arg
     * The comparable object to compare with this set.
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
        printf("MultisetAsArray main program.\n");
        $status = 0;
        $s1 = new MultisetAsArray(57);
        $s2 = new MultisetAsArray(57);
        $s3 = new MultisetAsArray(57);
        AbstractMultiset::test($s1, $s2, $s3);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(MultisetAsArray::main(array_slice($argv, 1)));
}
?>
