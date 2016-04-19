<?php
/**
 * @copyright Copyright &copy; 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: NaryTree.php,v 1.4 2005/12/09 01:11:14 brpreiss Exp $
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
 * Represents a node in an N-ary tree.
 *
 * @package Opus11
 */
class NaryTree
    extends AbstractTree
{
    /**
     * @var object IObject The key in this node.
     */
    protected $key = NULL;
    /**
     * @var integer The degree of this node.
     */
    protected $degree = 0;
    /**
     * @var object BasicArray The subtrees of this node.
     */
    protected $subtree = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Construct an NaryTree with the specified degree
     * and the specified key.
     *
     * @param integer $degree The desired degree.
     * @param mixed $key The desired key.
     */
    public function __construct($degree, $key = NULL)
    {
        parent::__construct();
        $this->key = $key;
        $this->degree = $degree;
        if ($this->key === NULL)
        {
            $this->subtree = NULL;
        }
        else
        {
            $this->subtree = new BasicArray($degree);
            for ($i = 0; $i < $degree; ++$i)
            {
                $this->subtree[$i] = new NaryTree($degree);
            }
        }
    }
//}>a

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->key = NULL;
        $this->subtree = NULL;
        parent::__destruct();
    }

    /**
     * Purges this N-ary tree node, making it empty.
     */
    public function purge()
    {
        $this->key = NULL;
        $this->subtree = NULL;
    }

    /**
     * Returns the degree of this N-ary tree node.
     *
     * @return integer The degree of this node.
     */
    public function getDegree()
    {
        return $this->isEmpty() ? 0 : $this->degree;
    }

    /**
     * Tests whether this N-ary tree node is a leaf node.
     *
     * @return boolean True if this node is not empty and all its subtree are;
     * false otherwise.
     */
    public function isLeaf()
    {
        if ($this->isEmpty())
            return false;
        for ($i = 0; $i < $this->degree; ++$i)
            if (!$this->subtree[$i]->isEmpty())
                return false;
        return true;
    }

//{
    /**
     * Tests whether this N-ary tree node is empty.
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
     * @return object IObject The key of this N-ary tree node.
     */
    public function getKey()
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        return $this->key;
    }

    /**
     * Attaches the specified object as the key of this N-ary tree node.
     * The node must be initially empty.
     *
     * @param object IObject $obj The key to attach.
     */
    public function attachKey(IObject $obj)
    {
        if (!$this->isEmpty())
            throw new IllegalOperationException();
        $this->key = $obj;
        $this->subtree = new BasicArray($this->degree);
        for ($i = 0; $i < $this->degree; ++$i)
            $this->subtree[$i] = new NaryTree($this->degree);
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
        $this->subtree = NULL;
        return $result;
    }
//}>c

//{
    /**
     * Returns the specified subtree of this node.
     *
     * @param integer $i The desired subtree.
     * @return object NaryTree The specified subtree of this node.
     */
    public function getSubtree($i)
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        return $this->subtree[$i];
    }

    /**
     * Attaches the specified tree as the specified subtree of this node.
     *
     * @param integer $i The number of the subtree of this node.
     * @param object NaryTree $t The tree to attach.
     */
    public function attachSubtree($i, NaryTree $t)
    {
        if ($this->isEmpty() || !$this->subtree[$i]->isEmpty())
            throw new IllegalOperationException();
        $this->subtree[$i] = $t;
    }

    /**
     * Detaches and returns the speicfied subtree of this node
     *
     * @param integer $i The number of the subtree to detach.
     * @return object NaryTree The specified subtree.
     **/
    public function detachSubtree($i)
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        $result = $this->subtree[$i];
        $this->subtree[$i] = new NaryTree($this->degree);
        return $result;
    }
//}>d

    /**
     * Compares this N-ary tree with the specified comparable object.
     * This method is not implemented.
     *
     * @param object IComparable $arg
     * The comparable object with which to compare this tree.
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
        printf("NaryTree main program.\n");
        $status = 0;
        $nt = new NaryTree(3, box(1));
        $nt->attachSubtree(0, new NaryTree(3, box(2)));
        $nt->attachSubtree(1, new NaryTree(3, box(3)));
        $nt->attachSubtree(2, new NaryTree(3, box(4)));
        AbstractTree::test($nt);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(NaryTree::main(array_slice($argv, 1)));
}
?>
