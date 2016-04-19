<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: BinaryTree.php,v 1.7 2005/12/09 01:11:07 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractTree.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/Exceptions.php';
require_once 'Opus11/Box.php';

//{
/**
 * Represents a node in an binary tree.
 *
 * @package Opus11
 */
class BinaryTree
    extends AbstractTree
{
    /**
     * @var object IObject The key in this node.
     */
    protected $key = NULL;
    /**
     * @var object BinaryTree The the left subtree of this node.
     */
    protected $left = NULL;
    /**
     * @var object BinaryTree The the right subtree of this node.
     */
    protected $right = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a BinaryTree with the specified key,
     * and the specified left and right subtree.
     *
     * @param object IObject $key The key in this node.
     * @param mixed $left The left subtree of this node.
     * @param mixed $right The left subtree of this node.
     */
    public function __construct(
        $key = NULL, $left = NULL, $right = NULL)
    {
        parent::__construct();
        $this->key = $key;
        if ($key === NULL)
        {
            $this->left = NULL;
            $this->right = NULL;
        }
        elseif ($left === NULL)
        {
            $this->left = new BinaryTree();
            $this->right = new BinaryTree();
        }
        else
        {
            $this->left = $left;
            $this->right = $right;
        }
    }
//}>a

//{
    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->key = NULL;
        $this->left = NULL;
        $this->right = NULL;
        parent::__destruct();
    }
//}>b

//{
    /**
    * Purges this binary tree node, making it empty.
    **/
    public function purge ()
    {
        $this->key = NULL;
        $this->left = NULL;
        $this->right = NULL;
    }
//}>c

    /**
     * Tests whether this node is a leaf node.
     *
     * @return boolean True if this node is a non-empty node
     * with two empty subtrees; false otherwise.
     */
    public function isLeaf()
    {
        return !$this->isEmpty() &&
            $this->left->isEmpty() &&
            $this->right->isEmpty();
    }

    /**
     * Returns the degree of this node.
     *
     * @return integer 2 if this node is non-empty; 0 otherwise.
     */
    public function getDegree()
    {
        return $this->isEmpty() ? 0 : 2;
    }

    /**
     * Tests whether this node is empty.
     *
     * @return boolean True if this node is empty; false otherwise.
     */
    public function isEmpty()
    {
        return $this->key === NULL;
    }

    /**
     * Key getter.
     *
     * @return object IObject The key in this node.
     */
    public function getKey()
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        return $this->key;
    }

    /**
     * Returns the specified subtree of this node.
     *
     * @param integer $i The number of the subtree to return.
     * @return object BinaryTree The specified subtree of this node.
     */
    public function getSubtree($i)
    {
        if ($i < 0 || $i >= 2)
            throw new IndexError();
        if ($i == 0)
            return $this->getLeft();
        else
            return $this->getRight();
    }

    /**
     * Attaches the specified object as the key of this node.
     * The node must be initially empty.
     *
     * @param object IObject $object The key to attach.
     */
    public function attachKey(IObject $obj)
    {
        if (!$this->isEmpty())
            throw new IllegalOperationException();
        $this->key = $obj;
        $this->left = new BinaryTree();
        $this->right = new BinaryTree();
    }

    /**
     * Detaches the key from this node; making it the empty node.
     */
    public function detachKey()
    {
        if (!$this->isLeaf())
            throw new IllegalOperationException();
        $result = $this->key;
        $this->key = NULL;
        $this->left = NULL;
        $this->right = NULL;
        return $result;
    }

    /**
     * Returns the left subtree of this node.
     *
     * @return object BinaryTree The left subtree of this node.
     */
    public function getLeft()
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        return $this->left;
    }

    /**
     * Attaches the specified binary tree as the left subtree of this node.
     *
     * @param object BinaryTree $t The new left subtree of this node.
     */
    public function attachLeft(BinaryTree $t)
    {
        if ($this->isEmpty() || !$this->left->isEmpty())
            throw new IllegalOperationException();
        $this->left = $t;
    }

    /**
     * Detaches and returns the left subtree of this node.
     *
     * @return object BinaryTree The left subtree of this node.
     */
    public function detachLeft()
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        $result = $this->left;
        $this->left = new BinaryTree();
        return $result;
    }

    /**
     * Returns the right subtree of this node.
     *
     * @return object BinaryTree The right subtree of this node.
     */
    public function getRight()
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        return $this->right;
    }

    /**
     * Attaches the specified binary tree as the right subtree of this node.
     *
     * @param object BinaryTree $t The new right subtree of this node.
     */
    public function attachRight(BinaryTree $t)
    {
        if ($this->isEmpty() || !$this->right->isEmpty())
            throw new IllegalOperationException();
        $this->right = $t;
    }

    /**
     * Detaches and returns the right subtree of this node.
     * @return object BinaryTree The right subtree of this node.
     */
    public function detachRight()
    {
        if ($this->isEmpty ())
            throw new IllegalOperationException();
        $result = $this->right;
        $this->right = new BinaryTree();
        return $result;
    }

//{
    /**
     * Causes a visitor to visit the nodes of this tree
     * in depth-first traversal order starting from this node.
     * This method invokes the preVisit, inVisit
     * and postVisit methods of the visitor
     * for each node in this tree.
     * @param object IPrePostVisitor $visitor The visitor to accept.
     */
    public function depthFirstTraversal(IPrePostVisitor $visitor)
    {
        if (!$this->isEmpty())
        {
            $visitor->preVisit($this->key);
            $this->left->depthFirstTraversal($visitor);
            $visitor->inVisit($this->key);
            $this->right->depthFirstTraversal($visitor);
            $visitor->postVisit($this->key);
        }
    }
//}>d

//{
    /**
     * Compares this binary tree with the specified comparable object.
     * The specified comparable object is assumed to be a BinaryTree instance.
     *
     * @param object IComparable $obj
     * The comparable object with which to compare this
     * binary tree.
     * @return integer A number less than zero if this binary tree is less
     * than the specified binary tree;
     * greater than zero if this binary tree is greater 
     * than the specified binary tree;
     * zero if the two trees are identical.
     */
    protected function compareTo(IComparable $obj)
    {
        if ($this->isEmpty())
            return $obj->isEmpty() ? 0 : -1;
        elseif ($obj->isEmpty())
            return 1;
        else
        {
            $result = $this->getKey()->compare($obj->getKey());
            if ($result == 0)
                $result = $this->getLeft()->compare(
                    $obj->getLeft());
            if ($result == 0)
                $result = $this->getRight()->compare(
                    $obj->getRight());
            return $result;
        }
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
        printf("BinaryTree main program.\n");
        $status = 0;
        $bt = new BinaryTree(box(4));
        $bt->attachLeft(new BinaryTree(box(2)));
        $bt->attachRight(new BinaryTree(box(6)));
        AbstractTree::test($bt);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(BinaryTree::main(array_slice($argv, 1)));
}
?>
