<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AVLTree.php,v 1.5 2005/12/09 01:11:02 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/BinarySearchTree.php';
require_once 'Opus11/Exceptions.php';
require_once 'Opus11/Box.php';

//{
/**
 * Represents a node in an AVL tree.
 *
 * @package Opus11
 */
class AVLTree
    extends BinarySearchTree
{
    /**
     * $var integer The height of this AVL tree node.
     */
    protected $height = -1;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs an empty AVLTree.
     */
    public function __construct()
    {
        parent::__construct(NULL, NULL, NULL);
        $this->height = -1;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Height getter.
     *
     * @return integer The height of this AVL tree node.
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Recomputes the height of this node from the heights
     * of the subtrees of this node.
     */
    protected function adjustHeight()
    {
        if ($this->isEmpty())
            $this->height = -1;
        else
            $this->height = 1 + max(
                $this->left->getHeight(),
                $this->right->getHeight());
    }

    /**
     * Returns the balance factor for this node.
     *
     * @return integer The difference between the heights of the left
     * and right subtrees of this node if this node is not empty;
     * zero if this node is empty.
     */
    protected function getBalanceFactor()
    {
        if ($this->isEmpty())
            return 0;
        else
            return $this->left->getHeight() -
                $this->right->getHeight();
    }
//}>b

//{
    /**
     * Performs an LL (single) rotation.
     */
    protected function doLLRotation()
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        $tmp = $this->right;
        $this->right = $this->left;
        $this->left = $this->right->left;
        $this->right->left = $this->right->right;
        $this->right->right = $tmp;

        $tmpObj = $this->key;
        $this->key = $this->right->key;
        $this->right->key = $tmpObj;

        $this->right->adjustHeight();
        $this->adjustHeight();
    }
//}>c

    /**
     * Performs an RR (single) rotation.
     */
    protected function doRRRotation()
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        $tmp = $this->left;
        $this->left = $this->right;
        $this->right = $this->left->right;
        $this->left->right = $this->left->left;
        $this->left->left = $tmp;

        $tmpObj = $this->key;
        $this->key = $this->left->key;
        $this->left->key = $tmpObj;

        $this->left->adjustHeight();
        $this->adjustHeight();
    }

//{
    /**
     * Performs an LR (double) rotation.
     */
    protected function doLRRotation()
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        $this->left->doRRRotation();
        $this->doLLRotation ();
    }
//}>d

    /**
     * Performs an RL (double) rotation.
     */
    protected function doRLRotation()
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        $this->right->doLLRotation();
        $this->doRRRotation();
    }

//{
    /**
     * AVL balances this node.
     */
    protected function balance()
    {
        $this->adjustHeight();
        if ($this->getBalanceFactor () > 1)
        {
            if ($this->left->getBalanceFactor() > 0)
                $this->doLLRotation ();
            else
                $this->doLRRotation ();
        }
        else if ($this->getBalanceFactor() < -1)
        {
            if ($this->right->getBalanceFactor() < 0)
                $this->doRRRotation ();
            else
                $this->doRLRotation ();
        }
    }
//}>e

//{
    /**
     * Attaches the specified object as the key of this node.
     * The node must be initially empty.
     *
     * @param object IObject $obj The key to attach.
     */
    public function attachKey(IObject $obj)
    {
        if (!$this->isEmpty ())
            throw new IllegalOperationException();
        $this->key = $obj;
        $this->left = new AVLTree();
        $this->right = new AVLTree();
        $this->height = 0;
    }
//}>f

//{
    /**
     * Detaches the key from this node; making it the empty node.
     */
    public function detachKey()
    {
        $this->height = -1;
        return parent::detachKey();
    }
//}>g

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AVLTree main program.\n");
        $status = 0;
        $bst = new AVLTree();
        AbstractSearchTree::test($bst);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AVLTree::main(array_slice($argv, 1)));
}
?>
