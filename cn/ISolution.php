<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ISolution.php,v 1.1 2005/12/07 01:50:21 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IComparable.php';

//{
/**
 * Represents a node in the solution space of a problem.
 *
 * @package Opus11
 */
interface ISolution
    extends IComparable
{
    /**
     * Tests whether this solution is feasible.
     * A feasible solution is one that satisfies all contraints.
     *
     * @return boolean True if this solution is feasible; false otherwise.
     */
    public abstract function isFeasible();
    /**
     * Tests whether this solution is a complete solution.
     * A partial solution is one in which
     * one or more decisions remain to be made.
     *
     * @return boolean True if this solution is complete; false otherwise.
     */
    public abstract function isComplete();
    /**
     * Returns the value of the objective function for this solution.
     *
     * @return integer The value of the objective function for this solution.
     */
    public abstract function getObjective();
    /**
     * Returns a lower-bound on the value of the objective function
     * for this solution and all other solutions in the solution space
     * that can be derived from this solution.
     * If the bound does not exist or if it cannot be computed,
     * this method returns <code>Integer.MAX_VALUE</code>.
     *
     * @return integer The lower-bound on the value of the objective function.
     */
    public abstract function getBound();
    /**
     * Returns the successors of this solution in the solution space.
     * A complete solution has no successors.
     * The successors of a partial solution are the solutions
     * obtained by considering all possible outcomes for
     * one of the decisions that remain to be made.
     *
     * @return object IteratorAggregate
     * The successors of this solution.
     */
    public abstract function getSuccessors();
}
//}>a
?>
