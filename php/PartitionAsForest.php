<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: PartitionAsForest.php,v 1.4 2005/12/09 01:11:14 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractPartition.php';
require_once 'Opus11/IPartition.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/PartitionTree.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * A partition implemented as a forest of trees.
 *
 * @package Opus11
 */
class PartitionAsForest
    extends AbstractPartition
    implements IPartition
{
    /**
     * var object BasicArray Array of partition trees.
     */
    protected $array = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a PartitionAsForest
     * with the specified number of elements in its universal set.
     *
     * @param integer $n The size of elements in the universal set.
     */
    public function __construct($n)
    {
        parent::__construct($n);
        $this->array = new BasicArray($this->universeSize);
        for ($item = 0; $item < $this->universeSize; ++$item)
        {
            $this->array[$item] =
                new PartitionTree($this, $item);
        }
        $this->count = $this->universeSize;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }
//}>a

    /**
     * Count getter.
     *
     * @return integer The count.
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Purges the partition, placing each element
     * of the universal set into its own element of the partition.
     */
    public function purge()
    {
        for ($item = 0; $item < $this->universeSize; ++$item)
            $this->array[$item]->purge();
    } 

//{
    /**
     * Finds the element of this partition
     * that contains the specified element of the universal set.
     *
     * @param integer $item The element of the universal set for which to look.
     * @return object ISet The element of this partition
     * that contains the specified element of the universal set.
     */
    public function findItem($item)
    {
        $ptr = $this->array[$item];
        while ($ptr->getParent() !== NULL)
            $ptr = $ptr->getParent();
        return $ptr;
    }
//}>b

//{
    /**
     * Checks whether the specified partition trees are distinct,
     * are both members of this partition,
     * and are both roots of their respective trees.
     *
     * @param object PartitionTree $s A partition tree.
     * @param object PartitionTree $t A partition tree.
     */
    protected function checkArguments(
        PartitionTree $s, PartitionTree $t)
    {
        if (!$this->contains($s) || $s->getParent() !== NULL ||
            !$this->contains($t) || $t->getParent() !== NULL ||
            $s === $t)
        {
            throw new ArgumentError();
        }
    }

    /**
     * Joins the specified elements of this partition.
     * It is assumed that both arguments
     * are elements of this partition.
     *
     * @param object ISet $p An element of this partition.
     * @param object ISet $q An element of this partition.
     */
    public function join(ISet $p, ISet $q)
    {
        $this->checkArguments($p, $q);
        $q->setParent($p);
        --$this->count;
    }
//}>c

    /**
     * Tests whether the given comparable object
     * is a member of this partition.
     *
     * @param object IComparable $obj The object for which to look.
     * @return boolean True if the object is a member of this partition;
     * false otherwise.
     */
    public function contains(IComparable $obj)
    {
        return $obj->isMemberOf($this);
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
        for ($i = 0; $i < $this->universeSize; ++$i)
        {
            $state = $callback($state, $this->array[$i]);
        }
        return $state;
    }

    /**
     * Accepts a visitor and makes it visit the elements of this partition.
     *
     * @param object IVisitor $visitor The visitor to accept.
     */
    public function accept(IVisitor $visitor)
    {
        for ($item = 0; $item < $this->universeSize; ++$item)
        {
            if ($visitor->isDone())
                return;
            $visitor->visit($this->array[$i]);
        }
    }

    /**
     * Undefined for partitions.
     */
    public function insertItem($i)
    {
        throw new IllegalOperationException(); 
    } 

    /**
     * Undefined for partitions.
     */
    public function withdrawItem($i)
    {
        throw new IllegalOperationException();
    } 

    /**
     * Undefined for partitions.
     */
    public function containsItem($i)
    {
        throw new IllegalOperationException();
    }

    /**
     * Returns an iterator that enumerates the elements of this partition.
     * This method is not implemented.
     */
    public function getIterator()
    {
        throw new MethodNotImplemented ();
    }

    /**
     * Undefined for partitions.
     */
    public function union(ISet $set)
    {
        throw new IllegalOperationException ();
    }

    /**
     * Undefined for partitions.
     */
    public function intersection(ISet $set)
    {
        throw new IllegalOperationException ();
    }

    /**
     * Undefined for partitions.
     */
    public function difference(ISet $set)
    {
        throw new IllegalOperationException();
    }

    /**
     * Tests whether this partition is equal to the specified set.
     * This method is not implemented.
     */
    public function eq(IComparable $set)
    {
        throw new MethodNotImplemented();
    }

    /**
     * Tests whether this partition is a subset of the specified set.
     * This method is not implemented.
     */
    public function isSubset(ISet $set)
    {
        throw new MethodNotImplemented ();
    }

    /**
     * Compares this partition with the specified comparable object.
     * This method is not implemented.
     *
     * @param object IComparable $obj
     * The object with which this partition is compared.
     */
    protected function compareTo(IComparable $arg)
    {
        throw new MethodNotImplemented ();
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("PartitionAsForest main program.\n");
        $status = 0;
        $p = new PartitionAsForest(5);
        AbstractPartition::test($p);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(PartitionAsForest::main(array_slice($argv, 1)));
}
?>
