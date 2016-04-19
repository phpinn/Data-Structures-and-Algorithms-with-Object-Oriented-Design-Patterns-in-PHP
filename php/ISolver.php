<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ISolver.php,v 1.1 2005/12/07 01:50:21 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IObject.php';

//{
/**
 * A solver is an abstract machine that solves a problem
 * by exploring its solution space.
 *
 * @package Opus11
 */
interface ISolver
    extends IObject
{
    /**
     * Returns an optimal solution to a given problem by searching its
     * solution space.
     * The optimal solution is a complete solution that
     * is feasible and for which the objective function is minimized
     *
     * @param object ISolution $initial
     * The initial node in the solution space from which to
     * begin the search
     * @return object ISolution The optimal solution.
     */
    public abstract function solve(ISolution $initial);
}
//}>a
?>
