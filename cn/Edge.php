<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Edge.php,v 1.3 2005/12/09 01:11:11 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractComparable.php';
require_once 'Opus11/IEdge.php';

//{
/**
 * Represents an edge in a graph.
 *
 * @package Opus11
 */
class Edge
    extends AbstractComparable
    implements IEdge
{
    /**
     * @var object AbstractGraph The graph with which this edge is associated.
     */
    protected $graph = NULL;
    /**
     * @var integer
     * The number of the vertex in this graph from which this edge emanates.
     */
    protected $v0 = 0;
    /**
     * @var integer
     * The number of the vertex in this graph upon which this edge
     * is incident.
     */
    protected $v1 = 0;
    /**
     * @var mixed The weight associated with this edge.
     */
    protected $weight = NULL;
//}@head

//{
//!    // ...
//!}
//}@tail

    /**
     * Constructs an Edge that connects
     * the specified vertices and with the specified weight.
     *
     * @param object AbstractGraph $graph
     * The graph with which this edge is associated.
     * @param integer $v0 The number of the vertex in this graph
     * from which this edge emanates.
     * @param integer $v1 The number of the vertex in this
     * upon which this edge is incident.
     * @param mixed $weight The weight associated with this edge.
     */
    public function __construct(AbstractGraph $graph, $v0, $v1, $weight)
    {
        parent::__construct();
        $this->graph = $graph;
        $this->v0 = $v0;
        $this->v1 = $v1;
        $this->weight = $weight;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->graph = NULL;
        $this->weight = NULL;
        parent::__destruct();
    }

    /**
     * V0 getter.
     *
     * @return object IVertex
     * The vertex in this graph from which this edge emenates.
     */
    public function getV0()
    {
        return $this->graph->getVertex($this->v0);
    }

    /**
     * V1 getter.
     *
     * @return object IVertex
     * The vertex in this graph upon which this edge is incident.
     */
    public function getV1()
    {
        return $this->graph->getVertex($this->v1);
    }
    
    /**
     * Weight getter.
     *
     * @return The weight associated with this edge.
     */
    public function getWeight()
    {
        return $this->weight;
    }
    
    /**
     * Returns the vertex at the end of this edge opposite
     * to the specified vertex.
     * It is always the case that
     * getMate(getV0())==getV1()
     * and
     * getMate(getV1())==getV0().
     *
     * @param object IVertex $v The specified vertex.
     * @return object IVertex The vertex opposite to the specified vertex.
     */
    public function getMate(IVertex $v)
    {
        if ($v->getNumber() == $this->v0)
            return $this->getV1();
        elseif ($v->getNumber() == $this->v1)
            return $this->getV0();
        else
            throw new ArgumentError();
    }

    /**
     * Tests whether this edge is directed.
     * An edge is directed if it is an edge in a directed graph.
     *
     * @return boolean True if this edge is directed.
     */
    public function isDirected()
    {
        return $this->graph->isDirected();
    }
    
    /**
     * Compares this edge with the specified comparable object.
     * This method is not implemented yet.
     */
    protected function compareTo(IComparable $obj)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * HashCode getter.
     *
     * @return A hashcode for this edge.
     */
    public function getHashCode()
    {
        $result = $this->v0 * $this->graph->getNumberOfVertices() + $v1;
        if ($this->weight !== NULL)
            $result += $weight->getHashCode();
        return $result;
    }
    
    /**
     * Returns a textual representation of this edge.
     *
     * @return string A string.
     */
    public function __toString()
    {
        $s = '';
        $s .= "Edge{" . str($this->v0);
        if ($this->isDirected())
            $s .= '->' . str($this->v1);
        else
            $s .= '--' . str($this->v1);
        if ($this->weight !== NULL)
            $s .= ', weight = ' . str($this->weight);
        $s .= '}';
        return $s;
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Edge main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Edge::main(array_slice($argv, 1)));
}
?>
