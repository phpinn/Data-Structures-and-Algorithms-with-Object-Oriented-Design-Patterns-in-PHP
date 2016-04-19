<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ZeroOneKnapsackProblem.php,v 1.3 2005/12/09 01:20:26 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSolution.php';
require_once 'Opus11/AbstractIterator.php';

/**
 * Enumeratest he successors of a node in a 0/1 knapsack problem.
 *
 * @package Opus11
 */
class ZeroOneKnapsackProblem_Node_SuccessorIterator
    extends AbstractIterator
{
    /**
     * @var object ZeroOneKnapsackProblem_Node The node.
     */
    protected $node = NULL;
    /**
     * @var integer The current value.
     */
    protected $value = 0;

    /**
     * Constructs a ZeroOneKnapsackProblem_Node_SuccessorIterator
     * for the given node.
     *
     * @param object ZeroOneKnapsackProblem_Node $node The node.
     */
    public function __construct(ZeroOneKnapsackProblem_Node $node)
    {
        parent::__construct();
        $this->node = $node;
        $this->value = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->node = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
        { return $this->value <= 1; }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
        { return $this->value; }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        $result = $this->node->copy();
        $result->placeNext($this->value);
        return $result;
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
        { $this->value += 1; }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
        { $this->value = 0; }
}

/**
 * Represents the successors of a given node of a 0/1 knapsack problem.
 *
 * @package Opus11
 */
class ZeroOneKnapsackProblem_Node_SuccessorAggregate
    implements IteratorAggregate
{
    /**
     * @var object ZeroOneKnapsackProblem_Node The node.
     */
    protected $node = NULL;

    /**
     * Constructs a ZeroOneKnapsackProblem_Node_SuccessorAggregate
     * for the given node.
     *
     * @param object ZeroOneKnapsackProblem_Node $node The node.
     */
    public function __construct(ZeroOneKnapsackProblem_Node $node)
    {
        $this->node= $node;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->node = NULL;
    }

    /**
     * Returns an iterator that enumerates the successors of the node.
     *
     * @return object Iterator An interator.
     */
    public function getIterator()
    {
        return new ZeroOneKnapsackProblem_Node_SuccessorIterator($this->node);
    }
}

/**
 * A node in the solution space of a 0/1 knapsack problem.
 *
 * @package Opus11
 */
class ZeroOneKnapsackProblem_Node
    extends AbstractSolution
{
    /**
     * @var object ZeroOneKnapsackProblem The 0/1 knapsack problem
     */
    protected $problem = NULL;
    /**
     * @var integer The current total profit.
     */
    protected $totalProfit = 0;
    /**
     * @var integer The current total weight.
     */
    protected $totalWeight = 0;
    /**
     * @var integer The sum of the profits of the items not yet considered.
     */
    protected $unplacedProfit = 0;
    /**
     * @var integer The number of items considered.
     */
    protected $numberPlaced = 0;
    /**
     * @var object BasicArray Indicates which items are taken.
     */
    protected $x = NULL;

    /**
     * Constructs the root node in the solution space of a
     * this 0/1 knapsack problem.
     */
    public function __construct(ZeroOneKnapsackProblem $problem)
    {
        parent::__construct();
        $this->problem = $problem;
        $this->totalWeight = 0;
        $this->totalProfit = 0;
        $this->unplacedProfit = 0;
        $this->numberPlaced = 0;
        $this->x = new BasicArray($this->problem->getNumberOfItems());

        $profit = $this->problem->getProfit();
        for ($i = 0; $i < $this->problem->getNumberOfItems(); ++$i)
            $this->unplacedProfit += $profit[$i];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->problem = NULL;
        $this->x = NULL;
        parent::__destruct();
    }

    /**
     * Returns a copy of this node.
     *
     * @return object ZeroOneKnapsackProblem_Node A copy of this node.
     */
    public function copy()
    {
        $result = new ZeroOneKnapsackProblem_Node($this->problem);
        $result->totalWeight = $this->totalWeight;
        $result->totalProfit = $this->totalProfit;
        $result->unplacedProfit = $this->unplacedProfit;
        $result->numberPlaced = $this->numberPlaced;
        for ($i = 0; $i < $this->problem->getNumberOfItems(); ++$i)
            $result->x[$i] = $this->x[$i];
        return $result;
    }

    /**
     * Returns the value of the objective function for this node.
     *
     * @return integer The value of the objective function.
     */
    public function getObjective()
    {
        return -$this->totalProfit;
    }

    /**
     * Returns a lower bound on the objective function for this node
     * and all possible descendants of this node in the solution space.
     *
     * @return integer A lower bound on the object function.
     */
    public function getBound()
    {
        return -($this->totalProfit + $this->unplacedProfit);
    }

    /**
     * Tests if this node is a feasible solution.
     *
     * @return boolean True always.
     */
    public function isFeasible()
    {
        return $this->totalWeight <= $this->problem->getCapacity();
    }

    /**
     * Tests if this node is a complete solution.
     *
     * @return boolean True if all the items have been considered for
     * placement in the knapsack;
     * false otherwise.
     */
    public function isComplete()
    {
        return $this->numberPlaced == $this->problem->getNumberOfItems();
    }

    /**
     * Places the next item into the knapsack if value is one.
     *
     * @param integer $value
     * Indicates whether to place the next item into the knapsack.
     */
    public function placeNext($value)
    {
        $this->x[$this->numberPlaced] = $value;
        $weight = $this->problem->getWeight();
        $profit = $this->problem->getProfit();
        if ($value == 1)
        {
            $this->totalWeight += $weight[$this->numberPlaced];
            $this->totalProfit += $profit[$this->numberPlaced];
            $this->unplacedProfit -= $profit[$this->numberPlaced];
        }
        ++$this->numberPlaced;
    }

    /**
     * Returns a textual representation of this node.
     *
     * @return string A string.
     */
    public function __toString()
    {
        $result = '';
        $comma = false;
        for ($i = 0; $i < $this->numberPlaced; ++$i)
        {
            if ($comma)
                $result .= ', ';
            $result .= str($this->x[$i]);
            $comma = true;
        }
        $result .= ' total weight = ' . str($this->totalWeight);
        $result .= ' total profit = ' . str($this->totalProfit);
        return $result;
    }

    /**
     * Returns a the successors of this node in the solution space.
     *
     * @return object IteratorAggregate The successors of this node.
     */
    public function getSuccessors()
    {
        return new ZeroOneKnapsackProblem_Node_SuccessorAggregate($this);
    }

    /**
     * Compares this node in the solution space with
     * the specified comparable object.
     * This method is not implemented.
     *
     * @param object IComparable $arg The specified object.
     */
    protected function compareTo(IComparable $arg)
    {
        throw new MethodNotImplementedException();
    }
}

/**
 * Represents a 0/1 knapsack problem.
 *
 * @package Opus11
 */
class ZeroOneKnapsackProblem
{
    /**
     * @var integer The total number of items from which to choose.
     */
    protected $numberOfItems = 0;
    /**
     * @var object BasicArray The weights of each of the items.
     */
    protected $weight = NULL;
    /**
     * @var object BasicArray
     * The profits associated with taking each of the items.
     */
    protected $profit = NULL;
    /**
     * @var integer The capacity of the knapsack.
     */
    protected $capacity = 0;

    /**
     * Constructs a ZeroOneKnapsackProblem
     * for the specified array of weights.
     *
     * @param weight An array of weights.
     */
    /**
     * Constructs a ZeroOneKnapsackProblem
     * with the specified weights, profits and capacity.
     *
     * @param object BasicArray $weight
     * The weights of the items to be considered.
     * @param object BasicArray $profit
     * The profits of the items to be considered.
     * @param integer $capacity The total capacity of the knapsack.
     */
    public function __construct(
        BasicArray $weight, BasicArray $profit, $capacity)
    {
        $this->numberOfItems = $weight->getLength();
        $this->weight = $weight;
        $this->profit = $profit;
        $this->capacity = $capacity;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->weight = NULL;
        $this->profit = NULL;
    }

    /**
     * Number of items getter.
     *
     * @return integer The number of items.
     */
    public function getNumberOfItems()
    {
        return $this->numberOfItems;
    }

    /**
     * Weight getter.
     *
     * @return object BasicArray The weight array.
     */
    public function & getWeight()
    {
        return $this->weight;
    }

    /**
     * Profit getter.
     *
     * @return object BasicArray The profit array.
     */
    public function & getProfit()
    {
        return $this->profit;
    }

    /**
     * Capacity getter.
     *
     * @return integer The capacity.
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Solves this 0/1 knapsack using the specified solver.
     *
     * @param object ISolver $solver The solver to use.
     * @return object ISolution The solution to this 0/1 knapsack problem.
     */
    public function solve(ISolver $solver)
    {
        $result = $solver->solve(new ZeroOneKnapsackProblem_Node($this));
        return $result;
    }
}
?>
