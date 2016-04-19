<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IDigraph.php,v 1.4 2005/12/09 01:11:12 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IGraph.php';

//{
/**
 * Interface implemented by all digraphs.
 *
 * @package Opus11
 */
interface IDigraph
    extends IGraph
{
    /**
     * Tests whether this graph is strongly connected.
     *
     * @return boolean
     * True if this graph is strongly connected; false otherwise.
     */
    public abstract function isStronglyConnected();
    /**
     * Causes a visitor to visit the vertices of this directed graph
     * in topological order.
     * This method takes a visitor and,
     * as long as the IsDone method of that visitor returns false,
     * this method invokes the Visit method of the visitor
     * for each vertex in the graph.
     * The order in which the vertices are visited
     * is given by a topological sort of the vertices.
     *
     * @param object IVisitor $visitor The visitor to accept.
     */
    public abstract function topologicalOrderTraversal(
        IVisitor $visitor);
}
//}>a
?>
