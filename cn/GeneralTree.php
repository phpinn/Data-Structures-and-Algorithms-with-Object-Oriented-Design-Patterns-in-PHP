<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: GeneralTree.php,v 1.5 2005/12/09 01:11:12 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractTree.php';
require_once 'Opus11/LinkedList.php';
require_once 'Opus11/Exceptions.php';
require_once 'Opus11/Box.php';

//{
/**
 * Represents a node in a general tree.
 *
 * @package Opus11
 */
class GeneralTree
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
     * @var object LinkedList A linked list of the subtrees of this node.
     */
    protected $list = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a GeneralTree with the specified key.
     *
     * @param object IObject $key The desired key.
     */
    public function __construct(IObject $key)
    {
        parent::__construct();
        $this->key = $key;
        $this->degree = 0;
        $this->list = new LinkedList();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->key = NULL;
        $this->list = NULL;
        parent::__destruct();
    }

    /**
     * Purges this general tree node, making it empty.
     */
    public function purge()
    {
        $this->list->purge();
        $this->degree = 0;
    }
//}>b

    /**
     * Tests whether this general tree node is empty.
     *
     * @return boolean False always.
     */
    public function isEmpty()
    {
        return false;
    }

    /**
     * Tests whether this general tree nodes is a leaf node.
     *
     * @return boolean True if the degree of this node is zero;
     * false otherwise.
     */
    public function isLeaf()
    {
        return $this->degree == 0;
    }

    /**
     * Degree getter.
     *
     * @return integer The degree of this node.
     */
    public function getDegree ()
    {
        return $this->degree;
    }

//{
    /**
     * Key getter.
     *
     * @return object IObject The key of this general tree node.
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Returns the specified subtree of this general tree node.
     *
     * @return object GeneralTree The desired subtree of this tree node.
     */
    public function getSubtree($i)
    {
        if ($i < 0 || $i >= $this->degree)
            throw new IndexError();
        $ptr = $this->list->getHead();
        for ($j = 0; $j < $i; ++$j)
            $ptr = $ptr->getNext();
        return $ptr->getDatum();
    }

    /**
     * Attaches the specified subtree to this general tree node.
     *
     * @param object GeneralTree $t The subtree to attach.
     */
    public function attachSubtree(GeneralTree $t)
    {
        $this->list->append($t);
        ++$this->degree;
    }

    /**
     * Detaches and returns the specified subtree of this general tree node.
     *
     * @param object GeneralTree $t The subtree to detach.
     */
    public function detachSubtree(GeneralTree $t)
    {
        $this->list->extract($t);
        --$this->degree;
        return $t;
    }
//}>c

    /**
     * Compares this general tree with the specified comparable object.
     * This method is not implemented.
     *
     * @param object IComparable $arg
     * The comparable object with which to compare this tree.
     **/
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
        printf("GeneralTree main program.\n");
        $status = 0;
        $gt = new GeneralTree(box('A'));
        $gt->attachSubtree(new GeneralTree(box('B')));
        $gt->attachSubtree(new GeneralTree(box('C')));
        $gt->attachSubtree(new GeneralTree(box('D')));
        $gt->attachSubtree(new GeneralTree(box('E')));
        AbstractTree::test($gt);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(GeneralTree::main(array_slice($argv, 1)));
}
?>
