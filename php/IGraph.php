<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IGraph.php,v 1.2 2005/12/09 01:11:12 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IContainer.php';
require_once 'Opus11/IEdge.php';
require_once 'Opus11/IVertex.php';

//{
/**
 * Interface implemented by all graphs.
 *
 * @package Opus11
 */
interface IGraph
    extends IContainer
{
    /**
     * Returns the number of edges in this graph.
     *
     * @return integer The number of edges in this graph.
     */
    public abstract function getNumberOfEdges();
    /**
     * Returns the number of vertices in this graph.
     *
     * @return integer The number of vertices in this graph.
     */
    public abstract function getNumberOfVertices();
    /**
     * Tests whether this graph is a directed graph.
     *
     * @return boolean True if this graph is directed; false otherwise.
     */
    public abstract function isDirected();
    /**
     * Adds a weighted vertex with a specified number to this graph.
     *
     * @param integer $v The number of the vertex to add.
     * @param mixed $weight The weight to be associated with the vertex.
     */
    public abstract function addVertex($v, $weight = NULL);
    /**
     * Returns the vertex in this graph with the specified number.
     *
     * @param integer $v The number of the vertex to be returned.
     * @return The vertex with the specified number.
     */
    public abstract function getVertex($v);
    /**
     * Adds a weighted edge to this graph that connects the two vertices
     * specified by their vertex numbers.
     *
     * @param integer $v The vertex at the tail of the edge.
     * @param integer $w The vertex at the head of the edge.
     * @param mixed $weight The weight to be associated with the edge.
     */
    public abstract function addEdge($v, $w, $weight = NULL);
    /**
     * Returns the edge that connects the two vertices
     * specified by their vertex numbers.
     *
     * @param integer $v The vertex at the tail of the edge.
     * @param integer $w The vertex at the head of the edge.
     * @return object IEdge The edge that connects the given vertices.
     */
    public abstract function getEdge($v, $w);
    /**
     * Tests whether there is an edge in this graph that connects
     * the two vertices specified by their numbers.
     * @param integer $v The vertex at the tail of the edge.
     * @param integer $w The vertex at the head of the edge.
     * @return boolean True if the edge exists; false otherwise.
     */
    public abstract function isEdge($v, $w);
    /**
     * Tests whether this graph is connected.
     * If this graph is an directed graph,
     * this method tests whether the graph is weakly connected.
     *
     * @return boolean True if this graph is weakly connected; false otherwise.
     */
    public abstract function isConnected();
    /**
     * Tests whether this graph is cyclic.
     *
     * @return True if this graph is cyclic; false otherwise.
     */
    public abstract function isCyclic();
    /**
     * Returns the vertices in this graph.
     *
     * @return object IteratorAggregate The vertices in this graph
     */
    public abstract function getVertices();
    /**
     * Returns The edges in this graph.
     *
     * @return object iteratorAggreagte The edges in this graph.
     */
    public abstract function getEdges();
    /**
     * Causes a visitor to visit the vertices of this directed graph
     * in depth-first traversal order starting from a given vertex.
     * This method invokes the PreVisit and PostVisit methods of the visitor
     * for each vertex in this graph.
     * The traversal continues as long as the IsDone method of the visitor
     * returns false.
     *
     * @param object IPrePostVisitor $visitor The visitor to accept.
     * @param integer $start The vertex at which to start the traversal.
     */
    public abstract function depthFirstTraversal(
        IPrePostVisitor $visitor, $start);
    /**
     * Causes a visitor to visit the vertices of this directed graph
     * in breadth-first traversal order starting from a given vertex.
     * This method invokes the Visit method of the visitor
     * for each vertex in this graph.
     * The traversal continues as long as the IsDone method of the visitor
     * returns false.
     *
     * @param object IVisitor $visitor The visitor to accept.
     * @param integer $start The vertex at which to start the traversal.
     */
    public abstract function breadthFirstTraversal(
        IVisitor $visitor, $start);
}
//}>a
?>
