<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractTree.php,v 1.7 2005/12/09 01:11:05 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/AbstractContainer.php';
require_once 'Opus11/StackAsLinkedList.php';
require_once 'Opus11/QueueAsLinkedList.php';
require_once 'Opus11/ITree.php';
require_once 'Opus11/PreOrder.php';
require_once 'Opus11/InOrder.php';
require_once 'Opus11/PostOrder.php';
require_once 'Opus11/PrintingVisitor.php';
require_once 'Opus11/ReducingVisitor.php';

//{
/**
 * An iterator that enumerates the items in a AbstractTree.
 *
 * @package Opus11
 */
class AbstractTree_Iterator
    extends AbstractIterator
{
    /**
     * The tree to enumerate.
     */
    protected $tree = NULL;
    /**
     * Used to keep track of the nodes to be enumerated.
     */
    protected $stack = NULL;
    /**
     * The current key.
     */
    protected $key = 0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a AbstractTree_Iterator for the given stack.
     *
     * @param object AbstractTree $tree The tree to enumerated.
     */
    public function __construct(AbstractTree $tree)
    {
        parent::__construct();
        $this->tree = $tree;
        $this->stack = new StackAsLinkedList();
        if (!$this->tree->isEmpty())
            $this->stack->push($this->tree);
        $this->key = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->tree = NULL;
        $this->stack = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
        { return !$this->stack->isEmpty(); }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
        { return $this->key; }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
        { return $this->stack->getTop()->getKey(); }
//}>d

//{
    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        $top = $this->stack->pop();
        for ($i = $top->getDegree() - 1; $i >= 0; --$i)
        {
            $subtree = $top->getSubtree($i);
            if (!$subtree->isEmpty())
            {
                $this->stack->push($subtree);
            }
        }
        ++$this->key;
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $this->stack = new StackAsLinkedList();
        if (!$this->tree->isEmpty())
            $this->stack->push($this->tree);
        $this->key = 0;
    }
//}>e
}

//{
/**
 * Abstract base class from which all tree classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractTree
    extends AbstractContainer
    implements ITree
{
//}@head

//{
//!    // ...
//!}
//}@tail

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

//{
    /**
     * Causes a visitor to visit the nodes of this tree
     * in depth-first traversal order starting from this node.
     * This method invokes the preVisit
     * and postVisit methods of the visitor
     * for each node in this tree.
     * The default implementation is recursive.
     * The default implementation never invokes the InVisit method
     * of the visitor.
     * The traversal continues as long as the isDone
     * method of the visitor returns false.
     *
     * @param object IPrePostVisitor $visitor The visitor to accept.
     */
    public function depthFirstTraversal(IPrePostVisitor $visitor)
    {
        if ($visitor->isDone())
            return;
        if (!$this->isEmpty())
        {
            $visitor->preVisit($this->getKey());
            for ($i = 0; $i < $this->getDegree(); ++$i)
                $this->getSubtree($i)->depthFirstTraversal(
                    $visitor);
            $visitor->postVisit($this->getKey());
        }
    }
//}>a

//{
    /**
     * Causes a visitor to visit the nodes of this tree
     * in breadth-first traversal order starting from this node.
     * This method invokes the visit method of the visitor
     * for each node in this tree.
     * The default implementation is iterative and uses a queue
     * to keep track of the nodes to be visited.
     * The traversal continues as long as the isDone
     * method of the visitor returns false.
     *
     * @param object IVisitor $visitor The visitor to accept.
     */
    public function breadthFirstTraversal(IVisitor $visitor)
    {
        $queue = new QueueAsLinkedList();
        if (!$this->isEmpty())
            $queue->enqueue($this);
        while (!$queue->isEmpty() && !$visitor->isDone())
        {
            $head = $queue->dequeue();
            $visitor->visit($head->getKey());
            for ($i = 0; $i < $head->getDegree(); ++$i)
            {
                $child = $head->getSubtree($i);
                if (!$child->isEmpty())
                    $queue->enqueue($child);
            }
        }
    }
//}>b

//{
    /**
     * Accepts a visitor and does a pre-order, depth-first traversal
     * with the visitor.
     *
     * @param object IVisitor $visitor The visitor to accept.
     */
    public function accept(IVisitor $visitor)
    {
        $this->depthFirstTraversal(new PreOrder($visitor));
    }
//}>c

    /**
     * Returns the height in the tree of this tree node.
     * The height of a node is the length of the longest path from
     * the node to a leaf.
     * The height of an external node is -1.
     *
     * @return integer The height of this tree node.
     */
    public function getHeight()
    {
        if ($this->isEmpty())
            return -1;
        $max = -1;
        for ($i = 0; $i < $this->getDegree(); ++$i)
            $max = max($max, $this->getSubtree($i)->getHeight());
        return $max + 1;
    }

    /**
     * Returns the number of internal nodes in this tree.
     *
     * @return integer The number of internal nodes in this tree.
     */
    public function getCount()
    {
        if ($this->isEmpty())
            return 0;
        $result = 1;
        for ($i = 0; $i < $this->getDegree(); ++$i)
            $result += $this->getSubtree($i)->getCount();
        return $result;
    }

    /**
     * Returns an iterator that enumerates the nodes of this tree.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new AbstractTree_Iterator($this);
    }

    /**
     * Tree test program.
     *
     * param tree The tree to test.
     */
     public static function test(ITree $tree)
     {
        printf("AbstractTree test program.\n");

        printf("Breadth-First traversal\n");
        $tree->breadthFirstTraversal(
            new PrintingVisitor(STDOUT));

        printf("Preorder traversal\n");
        $tree->depthFirstTraversal(new PreOrder(
            new PrintingVisitor(STDOUT)));

        printf("Inorder traversal\n");
        $tree->depthFirstTraversal(new InOrder(
            new PrintingVisitor(STDOUT)));

        printf("Postorder traversal\n");
        $tree->depthFirstTraversal(new PostOrder(
            new PrintingVisitor(STDOUT)));

        printf("Using foreach\n");
        foreach ($tree as $obj)
        {
            printf("%s\n", str($obj));
        }

        printf("Using reduce\n");
        $tree->reduce(create_function(
            '$sum,$obj', 'printf("%s\n", str($obj));'), '');

        printf("Using accept\n");
        $tree->accept(new ReducingVisitor(create_function(
            '$sum,$obj', 'printf("%s\n", str($obj));'), ''));
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractTree main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractTree::main(array_slice($argv, 1)));
}
?>
