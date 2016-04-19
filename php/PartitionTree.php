<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: PartitionTree.php,v 1.3 2005/12/09 01:11:15 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSet.php';
require_once 'Opus11/ITree.php';
require_once 'Opus11/ISet.php';
require_once 'Opus11/Exceptions.php';
require_once 'Opus11/Box.php';

//{
/**
 * A node in a partition tree.
 * A partition tree is an element of a partition.
 *
 * @package Opus11
 */
class PartitionTree
    extends AbstractSet
    implements ISet, ITree
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * @var object PartitionAsForest
     * The partition of which this tree is an element.
     */
    protected $partition = NULL;
    /**
     * @var integer An element of the universal set.
     */
    protected $item = 0;
    /**
     * @var object IPartitionTree The parent of this node.
     */
    protected $parent = NULL;
    /**
     * @var integer The rank of this node.
     */
    protected $rank = 0;

    /**
     * Constructs a PartitionTree
     * for the specified element of the universal set
     * a the specified Partition.
     *
     * @param object PartitionAsForest $partition The partition.
     * @param integer $item An element of the universal set.
     */
    public function __construct(
        PartitionAsForest $partition, $item)
    {
        parent::__construct($partition->getUniverseSize());
        $this->partition = $partition;
        $this->item = $item;
        $this->parent = NULL;
        $this->rank = 0;
        $this->count = 1;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->partition = NULL;
        $this->parent = NULL;
        parent::__destruct();
    }
//}>a

    /**
     * Parent getter.
     *
     * @return object PartitionTree The parent.
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Parent setter.
     *
     * @param object PartitionTree The parent.
     */
    public function setParent(PartitionTree $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Purges this partition tree node, making it into a singleton.
     */
    public function purge()
    {
        $this->parent = NULL;
        $this->rank = 0;
        $this->count = 1;
    }

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
     * Sets the count field to the specified value.
     *
     * @param integer $count The desired value.
     */
    public function setCount($count)
    {
        $this->count = $count;
    }
    
    /**
     * Tests whether this partition tree is an element
     * of the specified partition.
     *
     * @param partition The specified partition.
     * @return True if this partition tree is an element
     * of the specified partition; false otherwise.
     */
    public function isMemberOf(PartitionAsForest $partition)
    {
        return $this->partition == $partition;
    }

    /**
     * Rank getter.
     *
     * @return integer The rank of this partition tree.
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Height getter
     *
     * @return integer The height (rank) of this tree node.
     */
    public function getHeight()
    {
        return $this->getRank();
    }

    /**
     * Rank setter.
     *
     * @param integer The new rank.
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * Key getter.
     *
     * @return IComparable The key in this partition tree node.
     */
    public function getKey()
    {
        return new box($this->item);
    }

    /**
     * Compares this partition tree node with the
     * specified comparable object.
     * The specified comparable object is assumed to be
     * a PartitionTree instance.
     * The result is obtained by comparing the keys
     * in the respective partition tree nodes.
     *
     * @param object IComparable $obj
     * The comparable object with which to compare this partition tree.
     * @return integer A number less than zero if the key in this node
     * is less than that in the specified node;
     * a number greater than zero if the key in this node
     * is greater than that in the specified node;
     * zero if the two keys are equal.
     */
    protected function compareTo(IComparable $obj)
    {
        return $this->item - $obj->item;
    }

    /**
     * HashCode getter.
     *
     * @return The value of element of the universal set in this node.
     */
    public function getHashCode()
    {
        return $this->item;
    }

    /**
     * Returns a textual representation of this partition tree.
     *
     * @return string A string.
     */
    public function __toString()
    {
        $result = 'PartitionTree{' . str($this->item);
        if ($this->parent !== NULL)
            $result .=  ', ' . str($this->parent);
        return $result . '}';
    }

    /**
     * Undefined for partition trees.
     */
    public function insertItem($i)
    {
        throw new IllegalOperationException();
    }

    /**
     * Undefined for partition trees.
     */
    public function withdrawItem($i)
    {
        throw new IllegalOperationException();
    }

    /**
     * Tests whether the specified item is an element
     * of this partition tree.
     * This method is not implemented.
     */
    public function containsItem($i)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Tests whether this partition tree node is a leaf node.
     * This method is not implemented.
     */
    public function isLeaf()
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Tests whether this partition tree node is empty.
     *
     * @return boolean False always.
     */
    public function isEmpty()
    {
        return false;
    }

    /**
     * Returns the specified subtree of this partition tree node.
     */
    public function getSubtree($i)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Returns the degree of this partition tree node.
     */
    public function getDegree()
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Does a depth-first traversal of this partition tree.
     */
    public function depthFirstTraversal(IPrePostVisitor $visitor)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Does a breadth-first traversal of this partition tree.
     */
    public function breadthFirstTraversal(IVisitor $visitor)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Returns the union of the set represented by
     * this partition tree and the specified set.
     */
    public function union(ISet $set)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Returns the intersection of the set represented by
     * this partition tree and the specified set.
     */
    public function intersection(ISet $set)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Returns the difference between the set represented by
     * this partition tree and the specified set.
     */
    public function difference(ISet $set)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Tests whether the set represented by
     * this partition tree is equal to the specified set.
     */
    public function eq(IComparable $set)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Tests whether the set represented by
     * this partition tree is a subset of the specified set.
     */
    public function isSubset(ISet $set)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Returns an enumeration that enumerates the elements
     * of this partition tree.
     */
    public function getIterator()
    {
        throw new MethodNotImplementedException();
    }
}
?>
