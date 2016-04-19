<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IEdge.php,v 1.1 2005/12/04 02:02:09 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IComparable.php';

//{
/**
 * Interface implemented by all graph edges.
 *
 * @package Opus11
 */
interface IEdge
    extends IComparable
{
    /**
     * Returns one of the two vertices that this edge joins.
     * If this edge is a directed edge,
     * this method returns the tail of the arc.
     *
     * @return object IVertex One of the vertices that this edge joins.
     */
    public abstract function getV0();
    /**
     * Returns one of the two vertices that this edge joins.
     * If this edge is a directed edge,
     * this method returns the head of the arc.
     *
     * @return object IVertex One of the vertices that this edge joins.
     */
    public abstract function getV1();
    /**
     * Returns an object that represents the weight associated with this edge.
     *
     * @return mixed The weight associated with this edge.
     */
    public abstract function getWeight();
    /**
     * Tests whether this edge is a directed edge.
     * A directed edge is an edge in a directed graph.
     *
     * @return boolean True if this edge is a directed edge; false otherwise.
     */
    public abstract function isDirected();
    /**
     * Returns the vertex at the end of this edge opposite
     * to the specified vertex.
     * It is always the case that Mate(V0())==V1() and Mate(V1())==VO().
     *
     * @param object IVertex $vertex The specified vertex.
     */
    public abstract function getMate(IVertex $vertex);
}
//}>a
?>
