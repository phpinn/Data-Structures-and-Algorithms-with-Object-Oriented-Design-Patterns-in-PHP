<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ScalesBalancingProblem.php,v 1.3 2005/12/09 01:20:26 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSolution.php';
require_once 'Opus11/AbstractIterator.php';

/**
 * Enumerates the successors of a given node in a scales balancing problem.
 *
 * @package Opus11.
 */
class ScalesBalancingProblem_Node_SuccessorIterator
    extends AbstractIterator
{
    /**
     * @var object ScalesBalancingProblem_Node The node.
     */
    protected $node = NULL;
    /**
     * @var integer The current pan.
     */
    protected $pan = 0;

    /**
     * Constructs a ScalesBalancingProblem_Node_SuccessorIterator
     * for the given node.
     *
     * @param object ScalesBalancingProblem_Node $node The node.
     */
    public function __construct(ScalesBalancingProblem_Node $node)
    {
        parent::__construct();
        $this->node = $node;
        $this->pan = 0;
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
        { return $this->pan <= 1; }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
        { return $this->pan; }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        $result = $this->node->copy();
        $result->placeNext($this->pan);
        return $result;
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
        { $this->pan += 1; }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
        { $this->pan = 0; }
}

/**
 * Represents the successors of a given node of a scales balancing problem.
 *
 * @package Opus11
 */
class ScalesBalancingProblem_Node_SuccessorAggregate
    implements IteratorAggregate
{
    /**
     * @var object ScalesBalancingProblem_Node The node.
     */
    protected $node = NULL;

    /**
     * Constructs a ScalesBalancingProblem_Node_SuccessorAggregate
     * for the given node.
     *
     * @param object ScalesBalancingProblem_Node $node The node.
     */
    public function __construct(ScalesBalancingProblem_Node $node)
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
        return new ScalesBalancingProblem_Node_SuccessorIterator($this->node);
    }
}

/**
 * A node in the solution space of a scales balancing problem.
 *
 * @package Opus11
 */
class ScalesBalancingProblem_Node
    extends AbstractSolution
{
    /**
     * The scales balancing problem
     */
    protected $problem = NULL;
    /**
     * @var integer The current weight difference between the pans.
     */
    protected $diff = 0;
    /**
     * @var integer The current total weight of all unplaced weights.
     */
    protected $unplacedTotal = 0;
    /**
     * @var integer The number of weights placed into pans.
     */
    protected $numberPlaced = 0;
    /**
     * @var object BasicArray The pans in which the weights have been placed.
     */
    protected $pan = NULL;

    /**
     * Constructs the root node in the solution space of a
     * this scales balancing problem.
     */
    public function __construct(ScalesBalancingProblem $problem)
    {
        parent::__construct();
        $this->problem = $problem;
        $this->diff = 0;
        $this->unplacedTotal = 0;
        $this->numberPlaced = 0;
        $this->pan = new BasicArray($this->problem->getNumberOfWeights());
        $weights = $this->problem->getWeights();
        for ($i = 0; $i < $this->problem->getNumberOfWeights(); ++$i)
            $this->unplacedTotal += $weights[$i];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->problem = NULL;
        $this->pan = NULL;
        parent::__destruct();
    }

    /**
     * Returns a copy of this node.
     *
     * @return object ScalesBalancingProblem_Node A copy of this node.
     */
    public function copy()
    {
        $result = new ScalesBalancingProblem_Node($this->problem);
        $result->diff = $this->diff;
        $result->unplacedTotal = $this->unplacedTotal;
        $result->numberPlaced = $this->numberPlaced;
        for ($i = 0; $i < $this->problem->getNumberOfWeights(); ++$i)
            $result->pan[$i] = $this->pan[$i];
        return $result;
    }

    /**
     * Returns the value of the objective function for this node.
     * The result is the absolute value of the difference between
     * the total weights in the left and right pans.
     *
     * @return integer The value of the objective function.
     */
    public function getObjective()
    {
        return abs($this->diff);
    }

    /**
     * Returns a lower bound on the objective function for this node
     * and all possible descendants of this node in the solution space.
     *
     * @return integer A lower bound on the object function.
     */
    public function getBound()
    {
        if (abs($this->diff) > $this->unplacedTotal)
            return abs($this->diff) - $this->unplacedTotal;
        else
            return 0;
    }

    /**
     * Tests if this node is a feasible solution.
     *
     * @return boolean True always.
     */
    public function isFeasible()
    {
        return true;
    }

    /**
     * Tests if this node is a complete solution.
     *
     * @return boolean True if all the weights have been placed in a pan;
     * false otherwise.
     */
    public function isComplete()
    {
        return $this->numberPlaced == $this->problem->getNumberOfWeights();
    }

    /**
     * Places the next unplaced weight in the specified pan.
     *
     * @param integer $p The pan into which the next weight is placed.
     */
    public function placeNext($p)
    {
        $this->pan[$this->numberPlaced] = $p;
        $weights = $this->problem->getWeights();
        if ($p == 0)
            $this->diff += $weights[$this->numberPlaced];
        else
            $this->diff -= $weights[$this->numberPlaced];
        $this->unplacedTotal -= $weights[$this->numberPlaced];
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
            $result .= str($this->pan[$i]);
            $comma = true;
        }
        $result .= ' diff = ' . str($this->diff);
        return $result;
    }

    /**
     * Returns a the successors of this node in the solution space.
     *
     * @return object IteratorAggregate The successors of this node.
     */
    public function getSuccessors()
    {
        return new ScalesBalancingProblem_Node_SuccessorAggregate($this);
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
 * Represents a scales balancing problem.
 *
 * @package Opus11
 */
class ScalesBalancingProblem
{
    /**
     * @var integer The number of weights.
     */
    protected $numberOfWeights = 0;
    /**
     * @var object BasicArray The array of weights.
     */
    protected $weights = NULL;

    /**
     * Constructs a ScalesBalancingProblem
     * for the specified array of weights.
     *
     * @param weight An array of weights.
     */
    public function __construct(BasicArray $weights)
    {
        $this->weights = $weights;
        $this->numberOfWeights = $weights->getLength();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->weights = NULL;
    }

    /**
     * Number of weights getter.
     *
     * @return integer The number of weights.
     */
    public function getNumberOfWeights()
    {
        return $this->numberOfWeights;
    }

    /**
     * Weights getter.
     *
     * @return object BasicArray The weights.
     */
    public function & getWeights()
    {
        return $this->weights;
    }

    /**
     * Solves this scales-balancing problem using the specified solver.
     *
     * @param object ISolver $solver The solver to use.
     * @return object ISolution The solution to this scales-balancing problem.
     */
    public function solve(ISolver $solver)
    {
        $result = $solver->solve(new ScalesBalancingProblem_Node($this));
        return $result;
    }
}
?>
