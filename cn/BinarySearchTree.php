<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: BinarySearchTree.php,v 1.9 2005/12/09 01:11:07 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/BinaryTree.php';
require_once 'Opus11/ISearchTree.php';
require_once 'Opus11/AbstractSearchTree.php';
require_once 'Opus11/Exceptions.php';
require_once 'Opus11/Box.php';

//{
/**
 * Represents a node in an binary search tree.
 *
 * @package Opus11
 */
class BinarySearchTree
    extends BinaryTree
    implements ISearchTree
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs an empty BinarySearchTree.
     */
    public function __construct()
    {
        parent::__construct(NULL, NULL, NULL);
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
     * Tests whether the specified comparable object
     * is in this binary search tree.
     *
     * @param object IComparable $obj The object for which to look.
     * @return boolean True if the specified object
     * is in this binary search tree; false otherwise.
     */
    public function contains(IComparable $obj)
    {
        if ($this->isEmpty())
            return false;
        elseif (eq($obj, $this->getKey()))
            return true;
        elseif (lt($obj, $this->getKey()))
            return $this->getLeft()->contains($obj);
        else
            return $this->getRight()->contains($obj);
    }

//{
    /**
     * Returns the object in this binary search tree that matches
     * the specified object.
     *
     * @param object IComparable $obj The object to match.
     * @return mixed
     * The object in this binary search tree that matches
     * the specified object; NULL if not found.
     */
    public function find(IComparable $obj)
    {
        if ($this->isEmpty())
            return NULL;
        $diff = $obj->compare($this->getKey());
        if ($diff == 0)
            return $this->getKey();
        elseif ($diff < 0)
            return $this->getLeft()->find($obj);
        else
            return $this->getRight()->find($obj);
    }

    /**
     * Returns the "smallest" object in this binary search tree.
     * The smallest object is the object which is less than
     * all the other objects in this tree.
     * @return object IComparable
     * The "smallest" object in this binary search tree;
     * NULL if this tree is empty.
     */
    public function findMin()
    {
        if ($this->isEmpty ())
            return NULL;
        elseif ($this->getLeft()->isEmpty())
            return $this->getKey();
        else
            return $this->getLeft()->findMin();
    }
//}>c

    /**
     * Returns the "largest" object in this binary search tree.
     * The largest object is the object which is greater than
     * all the other objects in this tree.
     * @return object IComparable
     * The "largest" object in this binary search tree;
     * NULL if this tree is empty.
     */
    public function findMax()
    {
        if ($this->isEmpty ())
            return NULL;
        elseif ($this->getRight()->isEmpty())
            return $this->getKey();
        else
            return $this->getRight()->findMax();
    }

//{
    /**
     * Inserts the specified comparable object into this binary search tree.
     *
     * @param object IComparable $obj The object to be inserted.
     * @exception IllegalArgumentException
     * If there already is a matching object in this tree.
     */
    public function insert(IComparable $obj)
    {
        if ($this->isEmpty())
            $this->attachKey($obj);
        else
        {
            $diff = $obj->compare($this->getKey());
            if ($diff == 0)
                throw new ArgumentError();
            if ($diff < 0)
                $this->getLeft()->insert($obj);
            else
                $this->getRight()->insert($obj);
        }
        $this->balance();
    }

    /**
     * Attaches the specified object as the key of this node.
     * The node must be initially empty.
     *
     * @param object IObject $obj The key to attach.
     * @exception IllegalOperationException If this node is not empty.
     */
    public function attachKey(IObject $obj)
    {
        if (!$this->isEmpty())
            throw new IllegalOperationException();
        $this->key = $obj;
        $this->left = new BinarySearchTree();
        $this->right = new BinarySearchTree();
    }

    /**
     * Balances this node.
     * Does nothing in this class.
     */
    protected function balance ()
        {}
//}>d

//{
    /**
     * Withdraws the specified object from this binary search tree.
     *
     * @param object IObject $obj The object to be withdrawn from this tree.
     */
    public function withdraw(IComparable $obj)
    {
        if ($this->isEmpty ())
            throw new ArgumentError();
        $diff = $obj->compare($this->getKey());
        if ($diff == 0)
        {
            if (!$this->getLeft()->isEmpty())
            {
                $max = $this->getLeft()->findMax();
                $this->key = $max;
                $this->getLeft()->withdraw($max);
            }
            elseif (!$this->getRight()->isEmpty())
            {
                $min = $this->getRight()->findMin();
                $this->key = $min;
                $this->getRight()->withdraw($min);
            }
            else
                $this->detachKey();
        }
        else if ($diff < 0)
            $this->getLeft()->withdraw($obj);
        else
            $this->getRight()->withdraw($obj);
        $this->balance();
    }
//}>e

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("BinarySearchTree main program.\n");
        $status = 0;
        $bst = new BinarySearchTree();
        AbstractSearchTree::test($bst);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(BinarySearchTree::main(array_slice($argv, 1)));
}
?>
