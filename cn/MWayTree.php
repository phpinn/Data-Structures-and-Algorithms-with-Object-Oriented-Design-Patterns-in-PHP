<?php
/**
 * @copyright Copyright &copy; 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: MWayTree.php,v 1.6 2005/12/09 01:11:13 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSearchTree.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/StackAsLinkedList.php';
require_once 'Opus11/QueueAsLinkedList.php';
require_once 'Opus11/Exceptions.php';

/**
 * Enumerates the elements of an MWayTree.
 *
 * @package Opus11
 */
class MWayTree_Iterator
    extends AbstractIterator
{
    /**
     * @var object MWayTree The MWayTree being enumerated.
     */
    protected $tree = NULL;
    /**
     * @var integer The current position.
     */
    protected $position = 0;
    /**
     * @var object StackAsLinkedList A stack.
     */
    protected $stack = NULL;
    /**
     * @var integer The current key.
     */
    protected $key = 0;

    public function __construct(MWayTree $tree)
    {
        parent::__construct();
        $this->tree = $tree;
        $this->position = 1;
        $this->stack = new StackAsLinkedList();
        $this->key = 0;
        if (!$this->tree->isEmpty())
            $this->stack->push($this->tree);
    }

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
    {
        return $this->stack->getTop()->getKeyN($this->position);
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        $this->position += 1;
        if ($this->position >
            $this->stack->getTop()->getDegree() - 1)
        {
            $node = $this->stack->pop();
            for ($i = $node->getDegree() - 1; $i >= 0; --$i)
            {
                $subtree = $node->getSubtree($i);
                if (!$subtree->isEmpty())
                    $this->stack->push($subtree);
            }
            $this->position = 1;
        }
        $this->key += 1;
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $this->position = 1;
        $this->stack->purge();
        $this->key = 0;
        if (!$this->tree->isEmpty())
            $this->stack->push($this->tree);
    }
}

//{
/**
 * Represents node in an M-way tree.
 *
 * @package Opus11
 */
class MWayTree
    extends AbstractSearchTree
{
    /**
     * @var object BasicArray Array of keys.
     */
    protected $key = NULL;
    /**
     * @var object BasicArray Array of subtrees.
     */
    protected $subtree = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs an empty MWayTree with the specified order.
     *
     * @param integer $m The desired order.
     */
    public function __construct($m)
    {
        parent::__construct();
        $this->key = new BasicArray($m - 1, 1);
        $this->subtree = new BasicArray($m);
    }

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
     * Returns the order of this M-way tree node.
     *
     * @return integer The order of this M-way tree node.
     */
    public function getM()
    {
        return $this->subtree->getLength();
    }
//}>a

    /**
     * Purges this M-way tree node, making it empty.
     */
    public function purge()
    {
        for ($i = 1; $i <= $this->count; ++$i)
            $this->key[$i] = NULL;
        for ($i = 0; $i <= $this->count; ++$i)
            $this->subtree[$i] = NULL;
        $this->count = 0;
    }

    /**
     * Causes a visitor to visit the nodes of this tree
     * in breadth-first traversal order starting from this node.
     * This method invokes the <code>visit</code> method of the visitor
     * for each node in this tree.
     * Uses a queue to keep track of the nodes to be visited.
     * The traversal continues as long as the <code>isDone</code>
     * method of the visitor returns false.
     *
     * @param object IVisitor $visitor The visitor to accept.
     */
    public function breadthFirstTraversal(IVisitor $visitor)
    {
        $queue = new QueueAsLinkedList();

        if (!$this->isEmpty())
            $queue->enqueue($this);
        while (!$queue->isEmpty())
        {
            $head = $queue->dequeue();

            for ($i = 1; $i <= $head->getDegree() - 1; ++$i)
                $visitor->visit($head->getKeyN($i));

            for ($i = 0; $i <= $head->getDegree() - 1; ++$i)
            {
                $child = $head->getSubtree($i);
                if (!$child->isEmpty())
                    $queue->enqueue($child);
            }
        }
    }

    /**
     * Tests whether this M-way tree node is empty.
     *
     * @return boolean True if this M-way tree node is empty; false otherwise.
     */
    public function isEmpty()
    {
        return $this->count == 0;
    }

    /**
     * Tests whether this M-way tree node is full.
     *
     * @return boolean True if this M-way tree node is full; false otherwise.
     */
    public function isFull()
    {
        return $this->count == $this->getM() - 1;
    }

    /**
     * Tests whether this M-way tree node is a leaf node.
     *
     * @return boolean True if this M-way tree node is not empty
     * and all its subtrees are empty; false otherwise.
     */
    public function isLeaf()
    {
        if ($this->isEmpty())
            return false;
        for ($i = 0; $i <= $this->count; ++$i)
            if (!$this->subtree[$i]->isEmpty())
                return false;
        return true;
    }

    /**
     * Returns the degree of this M-way tree node.
     *
     * @return integer The degree of this M-way tree node.
     */
    public function getDegree()
    {
        if ($this->count == 0)
            return 0;
        else
            return $this->count + 1;
    }

    /**
     * Returns the specified key in this M-way tree node.
     *
     * @param integer $i The number of the key to return.
     * @return object IComparable The specified key in this M-way tree node
     */
    public function getKeyN($i = 0)
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        return $this->key[$i];
    }

    /**
     * Undefined in an M-way tree node.
     */
    public function getKey()
    {
        throw new IllegalOperationException ();
    }

    /**
     * Returns the specified subtree of this M-way tree node.
     *
     * @param integer $i The number of the subtree to return.
     * @return object MWayTree The specified subtree of this M-way tree node.
     */
    public function getSubtree($i)
    {
        if ($this->isEmpty())
            throw new IllegalOperationException();
        return $this->subtree[$i];
    }

//{
    /**
     * Causes a visitor to visit the nodes of this tree
     * in depth-first traversal order starting from this node.
     * This method invokes the preVisit, inVisit 
     * and postVisit methods of the visitor
     * for each node in this tree.
     *
     * @param object IPrePostVisitor $visitor The visitor to accept.
     */
    public function depthFirstTraversal(IPrePostVisitor $visitor)
    {
        if (!$this->isEmpty())
        {
            for ($i = 0; $i <= $this->count; ++$i)
            {
                if ($i >= 2)
                    $visitor->postVisit($this->key[$i - 1]);
                if ($i >= 1 && $i <= $this->count)
                    $visitor->inVisit($this->key[$i]);
                if ($i <= $this->count - 1)
                    $visitor->preVisit($this->key[$i + 1]);
                if ($i <= $this->count)
                    $this->subtree[$i]->depthFirstTraversal(
                        $visitor);
            }
        }
    }
//}>b

    /**
     * Returns the number of keys in this M-way tree.
     *
     * @return integer The number of keys in this M-way tree.
     */
    public function getCount()
    {
        if ($this->isEmpty())
            return 0;
        $result = $this->count;
        for ($i = 0; $i <= $this->count; ++$i)
            $result += $this->subtree[$i]->getCount();
        return $result;
    }

//{
    /**
     * Finds an object in this M-way tree that matches
     * the specified object.
     * Uses linear search.
     *
     * @param object IComparable $obj The object to match.
     * @return mixed An object that matches the specified one;
     * NULL if the tree is empty.
     */
    public function find(IComparable $obj)
    {
        if ($this->isEmpty())
            return NULL;
        for ($i = $this->count; $i > 0; --$i)
        {
            $diff = $obj->compare($this->key[$i]);
            if ($diff == 0)
                return $this->key[$i];
            if ($diff > 0)
                break;
        }
        return $this->subtree[$i]->find($obj);
    }
//}>c

    /**
     * Tests whether the specified object is a key in this M-way tree.
     *
     * @param object IComparable $obj The object for which to look.
     * @return boolean
     * True if the specified object is in this tree; false otherwise.
     */
    public function contains(IComparable $obj)
    {
        if ($this->isEmpty())
            return false;
        for ($i = $this->count; $i > 0; --$i)
        {
            if ($obj === $this->key[$i])
                return true;
            if (gt($obj, $this->key[$i]))
                break;
        }
        return $this->subtree[$i]->contains($obj);
    }

    /**
     * Finds the "smallest" key in this M-way tree.
     * The smallest key is the key which is less than or equal to
     * all other keys in the tree.
     *
     * @return object IComparable The "smallest" key in this M-way tree;
     * NULL if the tree is empty.
     */
    public function findMin()
    {
        if ($this->isEmpty())
            return NULL;
        elseif ($this->subtree[0]->isEmpty())
            return $this->key[1];
        else
            return $this->subtree[0]->findMin();
    }

    /**
     * Finds the "largest" key in this M-way tree.
     * The largest key is the key which is greater than or equal to
     * all other keys in the tree.
     * @return object IComparable The "largest" key in this M-way tree;
     * NULL if the tree is empty.
     */
    public function findMax()
    {
        if ($this->isEmpty())
            return NULL;
        elseif ($this->subtree[$this->count]->isEmpty())
            return $this->key[$this->count];
        else
            return $this->subtree[$this->count]->findMax();
    }

//{
    /**
     * Finds the position of the specified object
     * in the array of keys contained in this M-way tree node.
     * Uses binary search.
     *
     * @param object IComparable $obj The object for which to look.
     * @return integer The position of the object in the array of keys.
     * If the object is not present,
     * the result is the position of the largest key
     * less than the specified one.
     */
    protected function findIndex(IComparable $obj)
    {
        if ($this->isEmpty() || lt($obj, $this->key[1]))
            return 0;
        $left = 1;
        $right = $this->count;
        while ($left < $right)
        {
            $middle = intval(($left + $right + 1) / 2);
            if (lt($obj, $this->key[$middle]))
                $right = $middle - 1;
            else
                $left = $middle;
        }
        return $left;
    }

//[
    /**
     * Finds an object in this M-way tree that matches
     * the specified object.
     * Uses binary search.
     *
     * @param object IComparable $obj The object to match.
     * @return mixed An object that matches the specified one;
     * NULL if the tree is empty.
     **/
    public function findV2(IComparable $obj)
//]
    //!public function find(IComparable $obj)
    {
        if ($this->isEmpty())
            return NULL;
        $index = $this->findIndex($obj);
        if ($index != 0 && eq($object, $this->key[$index]))
            return $this->key[$index];
        else
            //!return $this->subtree[$index]->find($obj);
//[
            return $this->subtree[$index]->findV2($obj);
//]
    }
//}>d

//{
    /**
     * Inserts the specified object into this M-way tree.
     *
     * @param object IComparable $object The object to insert.
     */
    public function insert(IComparable $obj)
    {
        if ($this->isEmpty())
        {
            $this->subtree[0] = new MWayTree($this->getM());
            $this->key[1] = $obj;
            $this->subtree[1] = new MWayTree ($this->getM());
            $this->count = 1;
        }
        else
        {
            $index = $this->findIndex($obj);
            if ($index != 0 && eq($obj, $this->key[$index]))
                throw new ArgumentError();
            if (!$this->isFull())
            {
                for ($i = $this->count; $i > $index; --$i)
                {
                    $this->key[$i + 1] = $this->key[$i];
                    $this->subtree[$i + 1] = $this->subtree[$i];
                }
                $this->key[$index + 1] = $obj;
                $this->subtree[$index + 1] =
                    new MWayTree($this->getM());
                ++$this->count;
            }
            else
                $this->subtree[$index]->insert($obj);
        }
    }
//}>e

//{
    /**
     * Withdraws the specfied object from this M-way tree.
     * @param object IComparable $obj The object to withdraw.
     *
     */
    public function withdraw(IComparable $obj)
    {
        if ($this->isEmpty ())
            throw new ArgumentError();
        $index = $this->findIndex($obj);
        if ($index != 0 && eq($obj, $this->key[$index]))
        {
            if (!$this->subtree[$index - 1]->isEmpty())
            {
                $max = $this->subtree[$index - 1]->findMax();
                $this->key[$index] = $max;
                $this->subtree[$index - 1]->withdraw($max);
            }
            elseif (!$this->subtree[$index]->isEmpty())
            {
                $min = $this->subtree[$index]->findMin();
                $this->key[$index] = $min;
                $this->subtree[$index]->withdraw($min);
            }
            else
            {
                --$this->count;
                for ($i = $index; $i <= $this->count; ++$i)
                {
                    $this->key[$i] = $this->key[$i + 1];
                    $this->subtree[$i] = $this->subtree[$i + 1];
                }
                $this->key[$i] = NULL;
                $this->subtree[$i] = NULL;
                if ($this->count == 0)
                    $this->subtree[0] = NULL;
            }
        }
        else
            $this->subtree[$index]->withdraw($obj);
    }
//}>f

    /**
     * Returns an interator that enumerates
     * the nodes of this M-way tree.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new MWayTree_Iterator($this);
    }

    /**
     * Compares this M-way tree with the specified comparable object.
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
        printf("MWayTree main program.\n");
        $status = 0;
        $tree = new MWayTree(3);
        AbstractSearchTree::test($tree);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(MWayTree::main(array_slice($argv, 1)));
}
?>
