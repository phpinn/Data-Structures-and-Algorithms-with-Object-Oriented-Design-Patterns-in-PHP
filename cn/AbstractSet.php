<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractSet.php,v 1.8 2005/12/09 01:11:04 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSearchableContainer.php';
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/ISet.php';
require_once 'BoxedInteger.php';
require_once 'Exceptions.php';

/**
 * An iterator that enumerates the items in a AbstractSet.
 *
 * @package Opus11
 */
class AbstractSet_Iterator
    extends AbstractIterator
{
    /**
     * @var object ISet The set to enumerate.
     */
    protected $set = NULL;
    /**
     * @var integer The current item.
     */
    protected $item = 0;

    /**
     * Constructs a AbstractSet_Iterator for the given set.
     *
     * @param object ISet $set A set.
     */
    public function __construct(ISet $set)
    {
        parent::__construct();
        $this->set = $set;
        $this->item = 0;
        while ($this->item < $this->set->getUniverseSize() &&
            !$this->set->containsItem($this->item))
            ++$this->item;
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
        { return $this->item; }

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
        ++$this->item;
        while ($this->item < $this->set->getUniverseSize() &&
            !$this->set->containsItem($this->item))
            ++$this->item;
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $this->item = 0;
        while ($this->item < $this->set->getUniverseSize() &&
            !$this->set->containsItem($this->item))
            ++$this->item;
    }
}


//{
/**
 * Abstract base class from which all set classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractSet
    extends AbstractSearchableContainer
    implements ISet
{
    /**
     * The size of the universal set.
     */
    protected $universeSize = 0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs an AbstractSet with the given universe size.
     *
     * @param integer $universeSize The size of the universal set.
     */
    public function __construct($universeSize)
    {
        parent::__construct();
        $this->universeSize = $universeSize;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * UniverseSize getter.
     *
     * @return integer The size of the universal set.
     */
    public function getUniverseSize()
    {
        return $this->universeSize;
    }
//}>a

//{
    /**
     * Inserts the given object into this set.
     *
     * @param object IComparable $obj The object to insert.
     */
    public function insert(IComparable $obj)
    {
        $this->insertItem(unbox($obj));
    }

    /**
     * Withdraws the given object from this set.
     *
     * @param object IComparable $obj The object to withdraw.
     */
    public function withdraw(IComparable $obj)
    {
        $this->withdrawItem(unbox($obj));
    }

    /**
     * Contains predicate.
     *
     * @return boolean True if this set contains the given object.
     */
    public function contains(IComparable $obj)
    {
        return $this->containsItem(unbox($obj));
    }

    /**
     * Returns the given object if is contained in this set; otherwise NULL.
     * 
     * @return mixed The given object or NULL.
     */
    public function find(IComparable $obj)
    {
        if ($this->containsItem(unbox($obj)))
            return $obj;
        else
            return NULL;
    }
//}>b

    /**
     * Tests whether this set is empty.
     *
     * @return boolean True if this set is empty; false otherwise.
     */
    public function isEmpty()
    {
        for ($item = 0; $item < $this->universeSize; ++$item)
            if ($this->containsItem($item))
                return false;
        return true;
    }

    /**
     * Tests whether this set is full.
     *
     * @return boolean True if this set is full; false otherwise.
     */
    public function isFull()
    {
        for ($item = 0; $item < $this->universeSize; ++$item)
            if (!$this->containsItem($item))
                return false;
        return true;
    }

    /**
     * Returns the number of elements in this set.
     *
     * @return integer The number of elements in this set.
     */
    public function getCount()
    {
        $result = 0;
        for ($item = 0; $item < $this->universeSize; ++$item)
            if ($this->containsItem($item))
                ++$result;
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
     * @param mixed $initialState The initial state.
     * @return mixed The value returned by
     * the last call to the callback function.
     */
    public function reduce($callback, $initialState)
    {
        $state = $initialState;
        for ($item = 0; $item < $this->universeSize; ++$item)
        {
            if ($this->containsItem($item))
                $state = $callback($state, box($item));
        }
        return $state;
    }

    /**
     * Returns an iterator that enumerates the elements of this set.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new AbstractSet_Iterator($this);
    }

    /**
     * Set test method.
     *
     * @param object ISet $s1 A set to test.
     * @param object ISet $s2 A set to test.
     * @param object ISet $s3 A set to test.
     */
    public static function test(ISet $s1, ISet $s2, ISet $s3)
    {
        printf("AbstractSet test program.\n");

        for ($i = 0; $i < 4; ++$i)
        {
            $s1->insert(box($i));
        }
        for ($i = 2; $i < 6; ++$i)
        {
            $s2->insert(box($i));
        }
        $s3->insert(box(0));
        $s3->insert(box(2));
        printf("%s\n", str($s1));
        printf("%s\n", str($s2));
        printf("%s\n", str($s3));
        printf("%s\n", str($s1->union($s2))); # union
        printf("%s\n", str($s1->intersection($s3))); # intersection
        printf("%s\n", str($s1->difference($s3))); # difference

        printf("Using foreach\n");
        foreach ($s3 as $obj)
        {
            printf("%s\n", str($obj));
        }

        printf("Using reduce\n");
        $s3->reduce(create_function(
            '$sum,$obj', 'printf("%s\n", str($obj));'), '');
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractSet main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractSet::main(array_slice($argv, 1)));
}
?>
