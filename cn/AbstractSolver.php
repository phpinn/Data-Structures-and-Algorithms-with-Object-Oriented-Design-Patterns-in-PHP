<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractSolver.php,v 1.3 2005/12/09 01:11:04 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractObject.php';
require_once 'Opus11/ISolver.php';
require_once 'Opus11/Limits.php';

//{
/**
 * The AbstractSolver class is the base class
 * from which all concrete solver classes are derived.
 * This abstract class provides default implementations
 * for various methods declared in the Solver interface.
 *
 * @package Opus11
 */
abstract class AbstractSolver
    extends AbstractObject
    implements ISolver
{
    /**
     * @var object ISolution The current "best" solution.
     * I.e., of all the solutions encountered so far,
     * the one with the smallest objective function value.
     */
    protected $bestSolution = NULL;
    /**
     * @var integer The value of the objective function
     * for the current "best" solution.
     */
    protected $bestObjective = Limits::MAXINT;

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
        $this->bestSolution = NULL;
        parent::__destruct();
    }

//{
    /**
     * Searches the solution space for the optimal solution.
     * The optimal solution is a complete solution that
     * is feasible and for which the objective function is minimized.
     *
     * @param object ISolution $initial
     * The initial node in the solution space from which to begin the search.
     */
    protected abstract function search(ISolution $initial);

    /**
     * Returns an optimal solution to a given problem by searching its
     * solution space.
     * Calls the abstract search method to do the actual search.
     *
     * @param object ISolution $initial
     * The initial node in the solution space from which
     * to begin the search.
     * @return object ISolution The optimal solution.
     */
    public function solve(ISolution $initial)
    {
        $this->bestSolution = NULL;
        $this->bestObjective = Limits::MAXINT;
        $this->search($initial);
        return $this->bestSolution;
    }

    /**
     * Records the specified solution as the "best" solution
     * if it is a feasible solution and if the value of its objective function
     * is less than the current "best" solution.
     * This method is called by the search method
     * for every complete solution it generates.
     *
     * @param object ISolution $solution The specified complete solution.
     */
    public function updateBest(ISolution $solution)
    {
        if ($solution->isComplete () && $solution->isFeasible()
            && $solution->getObjective () < $this->bestObjective)
        {
            $this->bestSolution = $solution;
            $this->bestObjective = $solution->getObjective();
        }
    }
//}>a

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractSolver main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractSolver::main(array_slice($argv, 1)));
}
?>
