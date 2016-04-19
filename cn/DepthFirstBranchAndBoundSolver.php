<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: DepthFirstBranchAndBoundSolver.php,v 1.2 2005/12/09 01:11:10 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSolver.php';

//{
/**
 * Depth-first, branch-and-bound problem solver
 * for searching tree-structured solution spaces.
 *
 * @package Opus11
 */
class DepthFirstBranchAndBoundSolver
    extends AbstractSolver
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
     * Searches the solution space starting from the specified initial node.
     *
     * @param object ISolution $initial The root node of the solution space.
     */
    protected function search(ISolution $solution)
    {
        if ($solution->isComplete())
        {
            $this->updateBest($solution);
        }
        else
        {
            foreach ($solution->getSuccessors() as $successor)
            {
                if ($successor->isFeasible() &&
                    $successor->getBound() <
                    $this->bestObjective)
                {
                    $this->search($successor);
                }
            }
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
        printf("DepthFirstBranchAndBoundSolver main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(DepthFirstBranchAndBoundSolver::main(array_slice($argv, 1)));
}
?>
