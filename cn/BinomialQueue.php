<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: BinomialQueue.php,v 1.6 2005/12/09 01:11:07 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractMergeablePriorityQueue.php';
require_once 'Opus11/BinomialTree.php';
require_once 'Opus11/LinkedList.php';
require_once 'Opus11/PreOrder.php';
require_once 'Opus11/QueueAsLinkedList.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * A mergeable priority queue implemented as a forest of binomial trees.
 *
 * @package Opus11
 */
class BinomialQueue
    extends AbstractMergeablePriorityQueue
{
    /**
     * @var object BasicArray A linked list of binomial trees---the forest.
     */
    protected $treeList = NULL;


//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs an empty BinomialQueue.
     */
    public function __construct($size = 0)
    {
        parent::__construct();
        $this->treeList = new LinkedList();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->treeList = NULL;
        parent::__destruct();
    }
//}>a

//{
    /**
     * Adds the specified binomial tree to this binomial queue.
     *
     * @param object BinomialTree $tree The binomial tree to add.
     */
    protected function addTree(BinomialTree $tree)
    {
        $this->treeList->append($tree);
        $this->count += $tree->getCount();
    }

    /**
     * Removes the specified binomial tree from this binomial queue.
     *
     * @param object BinomialTree $tree The binomial tree to remove.
     */
    protected function removeTree(BinomialTree $tree)
    {
        $this->treeList->extract($tree);
        $this->count -= $tree->getCount();
    }
//}>b

    /**
     * Purges this binomial queue, making it empty.
     */
    public function purge()
    {
        $this->treeList = new LinkedList();
        $this->count = 0;
    }

    /**
     * Accepts the specified visitor and makes it visit all the objects
     * contained in this binomial queue.
     *
     * @param object IVisitor $visitor The visitor to accept.
     */
    public function accept(IVisitor $visitor)
    {
        for ($ptr = $this->treeList->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            $tree =  $ptr->getDatum();
            $tree->depthFirstTraversal(new PreOrder($visitor));
        }
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
        for ($ptr = $this->treeList->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            $tree =  $ptr->getDatum();
            $state = $tree->reduce($callback, $state);
        }
        return $state;
    }

//{
    /**
     * Returns the binomial tree in this binomial queue
     * that has the "smallest" root.
     * The smallest root is the root which is less than or
     * equal to all other roots.
     *
     * @return object BinomialTree The binomial tree in this binomial queue
     * that has the "smallest" root.
     */
    protected function findMinTree()
    {
        $minTree = NULL;
        for ($ptr = $this->treeList->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            $tree = $ptr->getDatum();
            if ($minTree === NULL ||
                lt($tree->getKey(), $minTree->getKey()))
                $minTree = $tree;
        }
        return $minTree;
    }

    /**
     * Returns the "smallest" object in this binomial queue.
     * The smallest object in this binomial queue is the object
     * that is less than or equal to all other objects in this
     * binomial queue.
     *
     * @return object IComparable The "smallest" object in this binomial queue.
     */
    public function findMin()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        return $this->findMinTree()->getKey();
    }
//}>c

//{
    /**
     * Merges the specified mergeable priority queue
     * with this binomial queue.
     * The specified binomial queue is assuemed to be
     * a BinomialQueue instance.
     * After merging, the specified queue is empty.
     * @param object IMergeablePriorityQueue $queue
     * The mergeable priority queue to merge with this binomial queue.
     */
    public function merge(IMergeablePriorityQueue $queue)
    {
        $treeList = $this->treeList;
        $this->treeList = new LinkedList();
        $this->count = 0;
        $p = $treeList->getHead();
        $q = $queue->treeList->getHead();
        $sum = NULL;
        $carry = NULL;
        for ($i = 0;
            $p !== NULL || $q !== NULL || $carry !== NULL; ++$i)
        {
            $a = NULL;
            if ($p !== NULL)
            {
                $tree = $p->getDatum();
                if ($tree->getDegree() == $i)
                {
                    $a = $tree;
                    $p = $p->getNext();
                }
            }
            $b = NULL;
            if ($q !== NULL)
            {
                $tree = $q->getDatum();
                if ($tree->getDegree() == $i)
                {
                    $b = $tree;
                    $q = $q->getNext();
                }
            }
            list($sum, $carry) = self::fullAdder($a, $b, $carry);
            if ($sum !== NULL)
                $this->addTree($sum);
        }
        $queue->purge();
    }
//}>d

//{
    /**
     * Returns the "sum" and "carray" that results
     * when three binomial trees are "added".
     * Each argument is either a binomial tree or NULL.
     * All three trees are assumed to have the same order.
     *
     * @param mixed $a A binomial tree.
     * @param mixed $b A binomial tree.
     * @param mixed $c A binomial tree.
     * @return object BinomialTree
     * The "sum" which results when three binomial trees are "added".
     */
    public static function fullAdder($a, $b, $c)
    {
        if ($a !== NULL) {
            if ($b !== NULL) {
                if ($c !== NULL) {
                    return array($a->add($b), $c);
                }
                else {
                    return array(NULL, $a->add($b));
                }
            }
            else {
                if ($c !== NULL) {
                    return array(NULL, $a->add($c));
                }
                else {
                    return array($a, NULL);
                }
            }
        }
        else {
            if ($b !== NULL) {
                if ($c !== NULL) {
                    return array($NULL, $b->add($c));
                }
                else {
                    return array($b, NULL);
                }
            }
            else {
                if ($c !== NULL) {
                    return array($c, NULL);
                }
                else {
                    return array(NULL, NULL);
                }
            }
        }
    }
//}>e

//{
    /**
     * Enqueues the specified object in this binomial queue.
     *
     * @param object IComparable $obj The object to enqueue.
     */
    public function enqueue(IComparable $obj)
    {
        $queue = new BinomialQueue();
        $queue->addTree(new BinomialTree($obj));
        $this->merge($queue);
    }
//}>f

//{
    /**
     * Dequeues and returns the "smallest" object in this binomial queue.
     * The smallest object in this binomial queue is the object
     * that is less than or equal to all other objects in this
     * binomial queue.
     *
     * @return object IComparable The "smallest" object in this binomial queue.
     */
    public function dequeueMin()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();

        $minTree = $this->findMinTree();
        $this->removeTree($minTree);

        $queue = new BinomialQueue();
        while ($minTree->getDegree () > 0)
        {
            $child = $minTree->getSubtree(0);
            $minTree->detachSubtree($child);
            $queue->addTree($child);
        }
        $this->merge($queue);

        return $minTree->getKey();
    }
//}>g

    /**
     * Returns a textual representation of this binomial queue.
     *
     * @return string A string.
     */
    public function __toString()
    {
        $result = '';
        $result .= $this->getClass()->getName() . "{\n";
        for ($ptr = $this->treeList->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            $result .=  '    ' . str($ptr->getDatum()) . "\n";
        }
        $result .= "}\n";
        return $result;
    }

    /**
     * Returns an iterator that enumerates the objects
     * contained in this binomial queue.
     */
    public function getIterator()
    {
        $queue = new QueueAsLinkedList();
        $this->reduce(create_function(
            '$queue, $obj',
            '$queue->enqueue($obj); return $queue;'), $queue);
        return $queue->getIterator();
    }

    /**
     * Compares this binomial queue with the specified comparable object.
     * This method is not implemented.
     *
     * @param object IComparable $arg
     * The comparable object with which to compare this binomial queue.
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
        printf("BinomialQueue main program.\n");
        $status = 0;
        $pqueue = new BinomialQueue(5);
        AbstractPriorityQueue::test($pqueue);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(BinomialQueue::main(array_slice($argv, 1)));
}
?>
