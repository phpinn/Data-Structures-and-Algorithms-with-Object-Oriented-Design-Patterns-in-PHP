<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: BTree.php,v 1.4 2005/12/09 01:11:06 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/MWayTree.php';
require_once 'Opus11/Exceptions.php';
require_once 'Opus11/Box.php';

//{
/**
 * Represents node in an BTree.
 *
 * @package Opus11
 */
class BTree
    extends MWayTree
{
    /**
     * @var mixed The parent of this node.
     */
    protected $parent = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs an empty BTree with the specified order.
     *
     * @param integer $m The desired order.
     */
    public function __construct($m)
    {
        parent::__construct($m);
        $this->parent = NULL;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->parent = NULL;
        parent::__destruct();
    }

    /**
     * Attaches the specified B-tree as the specified subtree of this B-tree.
     *
     * @param integer $i The position at which to attach the specified B-tree.
     * @param object BTree $btree The B-tree to attach.
     */
    public function attachSubtree($i, BTree $btree)
    {
        $this->subtree[$i] = $btree;
        $btree->parent = $this;
    }
//}>a

//{
    /**
     * Inserts the specified object into this B-tree.
     *
     * @param object IComparable $obj The object to insert.
     */
    public function insert(IComparable $obj)
    {
        if ($this->isEmpty())
        {
            if ($this->parent === NULL)
            {
                $this->attachSubtree(
                    0, new BTree($this->getM()));
                $this->key[1] = $obj;
                $this->attachSubtree(
                    1, new BTree($this->getM()));
                $this->count = 1;
            }
            else
            {
                $this->parent->insertPair(
                    $obj, new BTree($this->getM()));
            }
        }
        else
        {
            $index = $this->findIndex($obj);
            if ($index != 0 && eq($object, $this->key[$index]))
                throw new ArgumentError();
            $this->subtree[$index]->insert($obj);
        }
    }
//}>b

//{
    /**
     * Inserts the specified object and B-tree into this B-tree node.
     *
     * @param object IComparable $obj
     * A key smaller than all the keys in the specified B-tree.
     * @param object BTree $child The specified B-tree.
     */
    protected function insertPair(IComparable $obj, BTree $child)
    {
        $index = $this->findIndex($obj);
        if (!$this->isFull())
        {
            $this->insertPairAt($index + 1, $obj, $child);
            ++$this->count;
        }
        else
        {
            list($extraKey, $extraTree) =
                $this->insertPairAt($index + 1, $obj, $child);
            if ($this->parent === NULL)
            {
                $left = new BTree($this->getM());
                $right = new BTree($this->getM());
                $left->attachLeftHalfOf($this);
                $right->attachRightHalfOf($this);
                $right->insertPair($extraKey, $extraTree);
                $this->attachSubtree(0, $left);
                $this->key[1] =
                    $this->key[intval(($this->getM() + 1)/2)];
                $this->attachSubtree(1, $right);
                $this->count = 1;
            }
            else
            {
                $this->count = intval(($this->getM() + 1)/2 - 1);
                $right = new BTree($this->getM());
                $right->attachRightHalfOf($this);
                $right->insertPair($extraKey, $extraTree);
                $this->parent->insertPair(
                    $this->key[intval(($this->getM() + 1)/2)],
                    $right);
            }
        }
    }
//}>c

    /**
     * Inserts the specified object and B-tree at the specified position
     * in the array of keys and subtrees (respectively) in this B-tree node,
     * moving keys and subtrees in the array to the right to make room.
     *
     * @param integer $index
     * The position in which to insert the specified object.
     * @param object IComparable $obj The object to insert.
     * @param object BTree $child The B-tree to insert.
     * @return array The object and B-tree that falls off the end of the array.
     */
    protected function insertPairAt($index, IComparable $obj, BTree $child)
    {
        if ($index == $this->getM())
            return array($obj, $child);
        $extraKey = $this->key[$this->getM() - 1];
        $extraTree = $this->subtree[$this->getM() - 1];
        for ($i = $this->getM() - 1; $i > $index; --$i)
        {
            $this->key[$i] = $this->key[$i - 1];
            $this->subtree[$i] = $this->subtree[$i - 1];
        }
        $this->key[$index] = $obj;
        $this->subtree[$index] = $child;
        $child->parent = $this;
        return array($extraKey, $extraTree);
    }

    /**
     * Attaches the left half of the keys and subtrees of the specified
     * B-tree to this B-tree node.
     *
     * @param object BTree $btree
     * The tree from which to remove the keys and subtrees.
     */
    protected function attachLeftHalfOf(BTree $btree)
    {
        $this->count = intval(($this->getM() + 1)/2 - 1);
        $this->attachSubtree(0, $btree->subtree[0]);
        for ($i = 1; $i <= $this->count; ++$i)
        {
            $this->key[$i] = $btree->key[$i];
            $this->attachSubtree($i, $btree->subtree[$i]);
        }
    }

    /**
     * Attaches the right half of the keys and subtrees of the specified
     * B-tree to this B-tree node.
     *
     * @param object BTree $btree
     * The tree from which to remove the keys and subtrees.
     */
    protected function attachRightHalfOf(BTree $btree)
    {
        $this->count =
            $this->getM() - intval(($this->getM() + 1)/2) - 1;
        $j = intval(($this->getM() + 1)/2);
        $this->attachSubtree(0, $btree->subtree[$j++]);
        for ($i = 1; $i <= $this->count; ++$i, ++$j)
        {
            $this->key[$i] = $btree->key[$j];
            $this->attachSubtree($i, $btree->subtree[$j]);
        }
    }

    /**
     * Withdraws the specified object from this B-tree.
     * This method is not implemented.
     *
     * @param object BTree $obj The object to withdraw from this B-tree.
     */
    public function withdraw(IComparable $obj)
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
        printf("BTree main program.\n");
        $status = 0;
        $tree = new BTree(3);
        AbstractSearchTree::test($tree);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(BTree::main(array_slice($argv, 1)));
}
?>
