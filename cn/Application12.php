<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Application12.php,v 1.3 2005/12/09 01:11:05 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/DepthFirstSolver.php';
require_once 'Opus11/DepthFirstBranchAndBoundSolver.php';
require_once 'Opus11/BreadthFirstSolver.php';
require_once 'Opus11/BreadthFirstBranchAndBoundSolver.php';
require_once 'Opus11/ScalesBalancingProblem.php';
require_once 'Opus11/ZeroOneKnapsackProblem.php';

/**
 * Provides application program number 12.
 *
 * @package Opus11
 */
class Application12
{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Application program number 12.\n");
        $status = 0;

        $solver1 = new DepthFirstSolver();
        $solver2 = new DepthFirstBranchAndBoundSolver();
        $solver3 = new BreadthFirstSolver();
        $solver4 = new BreadthFirstBranchAndBoundSolver();

        $weights = new BasicArray(array(20, 20, 2, 2, 1));
        $problem = new ScalesBalancingProblem($weights);
        printf("%s\n", str($problem->solve($solver1)));
        printf("%s\n", str($problem->solve($solver2)));
        printf("%s\n", str($problem->solve($solver3)));
        printf("%s\n", str($problem->solve($solver4)));

        $weights = new BasicArray(array(100, 50, 45, 20, 10, 5));
        $profits = new BasicArray(array(40, 35, 18, 4, 10, 2));
        $capacity = 100;
        $problem = new ZeroOneKnapsackProblem($weights, $profits, $capacity);
        printf("%s\n", str($problem->solve($solver1)));
        printf("%s\n", str($problem->solve($solver2)));
        printf("%s\n", str($problem->solve($solver3)));
        printf("%s\n", str($problem->solve($solver4)));

        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Application12::main(array_slice($argv, 1)));
}
?>
