<?php
/**
 * @copyright Copyright &copy; 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: LeftistHeap.php,v 1.4 2005/12/09 01:11:13 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/BinaryTree.php';
require_once 'Opus11/AbstractPriorityQueue.php';
require_once 'Opus11/IMergeablePriorityQueue.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * A node of a mergeable priority queue implemented as a leftist tree.
 *
 * @package Opus11
 */
class LeftistHeap
    extends BinaryTree
    implements IMergeablePriorityQueue
{
    /**
     * @var integer The null path length.
     */
    protected $nullPathLength = 0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs an LeftistHeap.
     *
     * @param mixed $key A key. (Optional).
     */
    public function __construct($key = NULL)
    {
        if ($key === NULL)
        {
            parent::__construct(NULL, NULL, NULL);
            $this->nullPathLength = 0;
        }
        else
        {
            parent::__construct(
                $key, new LeftistHeap(), new LeftistHeap());
            $this->nullPathLength = 1;
        }
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
     * Swaps the contents of this node with the specified node.
     *
     * @param object LeftistHeap $heap
     * The node with which to swap the contents of this node.
     */
    protected function swapContentsWith(LeftistHeap $heap)
    {
        list($this->key, $heap->key) =
            array($heap->key, $this->key);
        list($this->left, $heap->left) =
            array($heap->left, $this->left);
        list($this->right, $heap->right) =
            array($heap->right, $this->right);
        list($this->nullPathLength, $heap->nullPathLength) =
            array($heap->nullPathLength, $this->nullPathLength);
    }

    /**
     * Swaps the subtres of this node.
     */
    protected function swapSubtrees()
    {
        list($this->left, $this->right) =
            array($this->right, $this->left);
    }

//{
    /**
     * Merges the contents of the specified mergeable priority queue
     * with this leftist heap.
     * It is assumed that the specified priority queue is
     * a LeftistHeap instance.
     * After merging the contents,
     * the specified queue is empty.
     *
     * @param object IMergeablePriorityQueue $queue
     * The queue to merge with this one.
     */
    public function merge(IMergeablePriorityQueue $queue)
    {
        if ($this->isEmpty())
        {
            $this->swapContentsWith($queue);
        }
        elseif (!$queue->isEmpty())
        {
            if (gt($this->key, $queue->key))
                $this->swapContentsWith($queue);
            $this->right->merge($queue);
            if ($this->left->nullPathLength <
                    $this->right->nullPathLength)
                $this->swapSubtrees();
            $this->nullPathLength = 1 + min(
                $this->left->nullPathLength,
                $this->right->nullPathLength);
        }
    }
//}>b

//{
    /**
     * Enqueues the specified object in this leftist heap.
     *
     * @param object IComparable $obj The object to enqueue.
     */
    public function enqueue(IComparable $obj)
    {
        $this->merge(new LeftistHeap($obj));
    }
//}>c

//{
    /**
     * Returns the "smallest" object in this leftist heap.
     * The smallest object in this leftist heap
     * is the object that is less than or equal to
     * all other objects in this leftist heap.
     *
     * @return object IComparable The "smallest" object in this leftist heap.
     */
    public function findMin()
    {
        if ($this->isEmpty())
            throw new ContainerEmptyException();
        return $this->key;
    }
//}>d

//{
    /**
     * Dequeues and returns the "smallest" object in this leftist heap.
     * The smallest object in this leftist heap
     * is the object that is less than or equal to
     * all other objects in this leftist heap.
     *
     * @return object IComparable The "smallest" object in this leftist heap.
     */
    public function dequeueMin()
    {
        if ($this->isEmpty())
            throw new ContainerEmptyException();

        $result = $this->key;

        $left = $this->left;
        $right = $this->right;
        $this->purge();
        $this->swapContentsWith($left);
        $this->merge($right);

        return $result;
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
        printf("LeftistHeap main program.\n");
        $status = 0;
        $bst = new LeftistHeap();
        AbstractPriorityQueue::test($bst);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(LeftistHeap::main(array_slice($argv, 1)));
}
?>
