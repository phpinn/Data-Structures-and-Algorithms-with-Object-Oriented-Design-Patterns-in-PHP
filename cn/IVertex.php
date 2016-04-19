<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IVertex.php,v 1.1 2005/12/04 02:02:09 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IComparable.php';

//{
/**
 * Interface implemented by all graph vertices.
 *
 * @package Opus11
 */
interface IVertex
    extends IComparable
{
    /**
     * Returns the number of this vertex.
     * @return integer The number of this vertex.
     */
    public abstract function getNumber();
    /**
     * Returns an object the represents the weight associated with this vertex.
     * @return mixed The weight associated with this vertex.
     */
    public abstract function getWeight();
    /**
     * Returns the edges incident on this vertex.
     *
     * @return object IteratorAggregate
     * The edges incident on this vertex.
     */
    public abstract function getIncidentEdges();
    /**
     * Returns the edges emanating from this vertex.
     *
     * @return object IteratorAggregate The edges emanating from this vertex.
     */
    public abstract function getEmanatingEdges();
    /**
     * Returns the vertices that are the predecessors of this vertex.
     *
     * @return object IteratorAggregate
     * The vertices that are the predecessors of this vertex.
     */
    public abstract function getPredecessors();
    /**
     * Returns the vertices that are the successors of this vertex.
     *
     * @return object IteratorAggregate
     * The vertices that are the successors of this vertex.
     */
    public abstract function getSuccessors ();
}
//}>a
?>
