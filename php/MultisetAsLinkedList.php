<?php
/**
 * @copyright Copyright &copy; 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: MultisetAsLinkedList.php,v 1.3 2005/12/09 01:11:14 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractMultiset.php';
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/LinkedList.php';
require_once 'Opus11/Exceptions.php';
require_once 'Opus11/Box.php';

/**
 * An iterator that enumerates the items in a MultisetAsLinkedList.
 *
 * @package Opus11
 */
class MultisetAsLinkedList_Iterator
    extends AbstractIterator
{
    /**
     * @var object MultisetAsLinkedList The set to enumerate.
     */
    protected $set = NULL;
    /**
     * @var object LinkedList_Element The current list element.
     */
    protected $element = NULL;
    /**
     * @var integer The current position.
     */
    protected $position = 0;

    /**
     * Constructs a MultisetAsLinkedList_Iterator for the given set.
     *
     * @param object MultisetAsLinkedList $set A set.
     */
    public function __construct(MultisetAsLinkedList $set)
    {
        parent::__construct();
        $this->set = $set;
        $this->element = $this->set->getList()->getHead();
        $this->position = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->set = NULL;
        $this->element = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
        { return $this->element !== NULL; }

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
        { return $this->element->getDatum(); }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        $this->element = $this->element->getNext();
        ++$this->position;
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $this->element = $this->set->getList()->getHead();
        $this->position = 0;
    }
}

//{
/**
 * Multiset implemented using a linked list.
 *
 * @package Opus11
 */
class MultisetAsLinkedList
    extends AbstractMultiset
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
     * Constructs a MultisetAsLinkedList for the specified size
     * of universal set.
     *
     * @param integer $n The number of elements in the universal set.
     */
    public function __construct($n = 0)
    {
        parent::__construct($n);
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
     * @return object LinkedList The list of this multiset.
     */
    public function & getList()
    {
        return $this->list;
    }
//}>a

    /**
     * Inserts the specified item into this multiset.
     *
     * @param integer $item The item to insert.
     */
    public function insertItem($item)
    {
        $prevPtr = NULL;
        for ($ptr = $this->list->getHead (); $ptr !== NULL;
            $ptr = $ptr->getNext())
        {
            $datum = $ptr->getDatum();
            if (unbox($datum) >= $item)
                break;
            $prevPtr = $ptr;
        }
        if ($prevPtr === NULL)
            $this->list->prepend(box($item));
        else
            $prevPtr->insertAfter(box($item));
    }

    /**
     * Withdraws the specified item from this multiset.
     *
     * @param integer $item The item to be withdrawn.
     */
    public function withdrawItem($item)
    {
        for ($ptr = $this->list->getHead(); $ptr !== NULL;
            $ptr = $ptr->getNext())
        {
            $datum = $ptr->getDatum();
            if (unbox($datum) == $item)
            {
                $list->extract($datum);
                return;
            }
        }
    }

    /**
     * Tests if the specified item is a member of this multiset.
     *
     * @param integer $item The item for which to look.
     * @return boolean True if the item is a member of this multiset;
     * false otherwise.
     */
    public function containsItem($item)
    {
        for ($ptr = $this->list->getHead(); $ptr !== NULL;
            $ptr = $ptr->getNext())
        {
            $datum = $ptr->getDatum();
            if (unbox($datum) == $item)
                return true;
        }
        return false;
    }

    /**
     * Purges this multiset, making it empty.
     */
    public function purge()
    {
        $this->list = new LinkedList();
    }

    /**
     * Returns the number of elements in this multiset.
     *
     * @return integer The number of elements in this multiset.
     */
    public function getCount()
    {
        $result = 0;
        for ($ptr = $this->list->getHead(); $ptr !== NULL;
            $ptr = $ptr->getNext())
        {
            ++$result;
        }
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
        return $this->list->reduce($callback, $initialState);
    }

//{
    /**
     * Returns a multiset which is the union of this multiset
     * and the specified multiset.
     * It is assumed that the specified multiset is an instance of
     * the MultisetAsLinkedList class.
     *
     * @param IMultiset $multiset The multiset to join with this multiset.
     * @return object IMultiset
     * The union of this multiset with the specified multiset.
     */
    public function union(IMultiset $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        $result = new MultisetAsLinkedList($this->universeSize);
        $p = $this->list->getHead();
        $q = $set->list->getHead();
        while ($p !== NULL && q !== NULL)
        {
            if (le($p->getDatum(), $q->getDatum()))
            {
                $result->list->append($p->getDatum());
                $p = $p->getNext();
            }
            else
            {
                $result->list->append($q->getDatum());
                $q = $q->getNext();
            }
        }
        for ( ; $p !== NULL; $p = $p->getNext())
            $result->list->append($p->getDatum());
        for ( ; $q != NULL; $q = $q->getNext())
            $result->list->append($q->getDatum());
        return $result;
    }
//}>b

//{
    /**
     * Returns a multiset which is the intersection of this multiset
     * and the specified multiset.
     * It is assumed that the specified multiset is an instance of
     * the MultisetAsLinkedList class.
     *
     * @param IMultiset $multiset The multiset to intersect with this multiset.
     * @return object IMultiset
     * The intersection of this multiset with the specified multiset.
     */
    public function intersection(IMultiset $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        $result = new MultisetAsLinkedList($this->universeSize);
        $p = $this->list->getHead();
        $q = $set->list->getHead();
        while ($p !== NULL && $q !== NULL)
        {
            $diff = $p->getDatum()->compare($q->getDatum());
            if ($diff == 0)
                $result->list->append($p->getDatum());
            if ($diff <= 0)
                $p = $p->getNext();
            if ($diff >= 0)
                $q = $q->getNext();
        }
        return $result;
    }
//}>c

    /**
     * Returns a multiset which is the difference between this multiset
     * and the specified multiset.
     * It is assumed that the specified multiset is an instance of
     * the MultisetAsLinkedList class.
     *
     * @param IMultiset $multiset The multiset to subtract from this multiset.
     * @return object IMultiset
     * The difference between this multiset and the specified multiset.
     */
    public function difference(IMultiset $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        $result = new MultisetAsLinkedList($this->universeSize);
        $p = $this->list->getHead();
        $q = $set->list->getHead();
        while ($p !== NULL && $q !== NULL)
        {
            $diff = $p->getDatum()->compare($q->getDatum());
            if ($diff < 0)
                $result->list->append($p->getDatum());
            if ($diff <= 0)
                $p = $p->getNext();
            if ($diff >= 0)
                $q = $q->getNext();
        }
        for ( ; $p !== NULL; $p = $p->getNext())
            $result->list->append($p->getDatum());
        return $result;
    }

    /**
     * Tests whether this multiset is a subset of the specified multiset.
     * It is assumed that the specified multiset is an instance of
     * the MultisetAsLinkedList class.
     *
     * @param IMultiset $multiset The multiset to compare with this multiset.
     * @return boolean
     * True if the this multiset is a subset of the specified multiset;
     * false otherwise.
     */
    public function isSubset(IMultiset $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        $p = $this->list->getHead();
        $q = $set->list->getHead();

        while ($p !== NULL && $q !== NULL)
        {
            $diff = $p->getDatum().compare($q->getDatum());
            if ($diff == 0)
            {
                $p = $p->getNext();
                $q = $q->getNext();
            }
            elseif ($diff > 0)
                $q = $q->getNext();
            else
                return false;
        }
        if ($p !== NULL)
            return false;
        else
            return true;
    }

    /**
     * Tests whether this multiset is equal to the specified multiset.
     * It is assumed that the specified multiset is an instance of
     * the MultisetAsLinkedList class.
     *
     * @param IMultiset $multiset The multiset to compare with this multiset.
     * @return boolean True if the multisets are equal; false otherwise.
     */
    public function eq(IComparable $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        $p = $this->list->getHead();
        $q = $set->list->getHead();

        while ($p !== NULL && $q !== NULL)
        {
            if (ne($p->getDatum(), $q->getDatum()))
            {
                return false;
            }
            $p = $p->getNext();
            $q = $q->getNext();
        }
        if ($p !== NULL || $q !== NULL)
            return false;
        else
            return true;
    }

    /**
     * Returns an iterator the enumerates the elements of this multiset.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new MultisetAsLinkedList_Iterator($this);
    }

    /**
     * Compares this set with the specified comparable object.
     * This method is not implemented.
     *
     * @param object IComparble $arg
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
        printf("MultisetAsLinkedList main program.\n");
        $status = 0;
        $s1 = new MultisetAsLinkedList(57);
        $s2 = new MultisetAsLinkedList(57);
        $s3 = new MultisetAsLinkedList(57);
        AbstractMultiset::test($s1, $s2, $s3);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(MultisetAsLinkedList::main(array_slice($argv, 1)));
}
?>
