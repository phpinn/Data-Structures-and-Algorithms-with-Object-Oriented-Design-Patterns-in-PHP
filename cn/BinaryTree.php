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
require_once 'AbstractTree.php';
require_once 'BasicArray.php';
require_once 'Exceptions.php';
require_once 'Box.php';

//{
/**
 * 二叉树实现
 *
 * @package Opus11
 */
class BinaryTree
    extends AbstractTree
{
    /**
     * @var 当前节点的值
     */
    protected $key = NULL;
    /**
     * @var 当前二叉树的左节点.
     */
    protected $left = NULL;
    /**
     * @var 当前二叉树的右节点.
     */
    protected $right = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * 以指定的值构造二叉树，并指定左右节点
     *
     * @param $key 节点的值
     * @param $left 左节点
     * @param $right 右节点
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
     * 析构方法.
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
    * 清空二叉树.
    **/
    public function purge ()
    {
        $this->key = NULL;
        $this->left = NULL;
        $this->right = NULL;
    }
//}>c

    /**
     * 判断当前节点是否是叶节点
     *
     * @return boolean 如果当前节点非空且有两个空的子节点时为true，否则为false.
     */
    public function isLeaf()
    {
        return !$this->isEmpty() &&
            $this->left->isEmpty() &&
            $this->right->isEmpty();
    }

    /**
     * 获得当前节点的度数.
     *
     * @return boolean 如果非空返回2，否则返回0.
     */
    public function getDegree()
    {
        return $this->isEmpty() ? 0 : 2;
    }

    /**
     * 判断当前节点是否为空
     *
     * @return boolean 如果为空返回True,否则false.
     */
    public function isEmpty()
    {
        return $this->key === NULL;
    }

    /**
     * 返回当前节点的值
     *
     * @return 当前节点的值
     */
    public function getKey()
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        return $this->key;
    }

    /**
     * 返回指定节点的子节点.
     *
     * @param $i 需要返回的子节点的序号，0为左节点，1为右节点.
     * @return 当前节点的子树.
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
     * 给节点赋值.
     * 当前节点必须为空.
     *
     * @param $object 添加的key值.
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
     * 删除节点，使节点为空
     * 节点不能有子树.
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
     * 返回当前节点的左子树.
     *
     * @return 节点的左子树.
     */
    public function getLeft()
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        return $this->left;
    }

    /**
     * 给当前节点增加左子树
     *
     * @param $t 当前节点的新子树.
     */
    public function attachLeft(BinaryTree $t)
    {
        if ($this->isEmpty() || !$this->left->isEmpty())
            throw new IllegalOperationException();
        $this->left = $t;
    }

    /**
     * 删除左子树.
     *
     * @return 删除的左子树.
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
     * 返回右子树.
     *
     * @return 返回当前节点的右子树.
     */
    public function getRight()
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        return $this->right;
    }

    /**
     * 给当前节点增加右子树
     *
     * @param $t 当前节点的新子树.
     */
    public function attachRight(BinaryTree $t)
    {
        if ($this->isEmpty() || !$this->right->isEmpty())
            throw new IllegalOperationException();
        $this->right = $t;
    }

    /**
     * 删除右子树.
     *
     * @return 删除的右子树.
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
