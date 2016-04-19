<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Vertex.php,v 1.4 2005/12/09 01:11:18 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractComparable.php';
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/IVertex.php';

/**
 * Iterator that enumerates the vertices adjacent to a given vertex
 * using a given edge iterator.
 *
 * @package Opus11
 */
class Vertex_Iterator
    extends AbstractIterator
{
    /**
     * @var object Vertex A vertex.
     */
    protected $vertex = NULL;
    /**
     * @var object Iterator An edge iterator.
     */
    protected $edgeIterator = NULL;

    /**
     * Constructs a Vertex_Iterator from the given set of edges.
     *
     * @param object Vertex $vertex This vertex.
     * @param object Iterator $edgeIterator An edge iterator.
     */
    public function __construct(Vertex $vertex, Iterator $edgeIterator)
    {
        parent::__construct();
        $this->vertex = $vertex;
        $this->edgeIterator = $edgeIterator;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->vertex = NULL;
        $this->edgeIterator = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
    {
        return $this->edgeIterator->valid();
    }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
    {
        return $this->edgeIterator->key();
    }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        return $this->edgeIterator->current()->getMate($this->vertex);
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        $this->edgeIterator->next();
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $this->edgeIterator->rewind();
    }
}

/**
 * An aggregate of the vertices adjacent to a given vertex
 * in a given aggregate of edges.
 *
 * @package Opus11
 */
class Vertex_IteratorAggregate
    implements IteratorAggregate
{
    /**
     * @var object Vertex A vertex.
     */
    protected $vertex = NULL;
    /**
     * @var object IteratorAggregate An aggregate of edges.
     */
    protected $edges = NULL;

    /**
     * Constructs a Vertex_IteratorAggregate from the given aggregate of edges.
     *
     * @param object IteratorAggregate $edges.
     */
    public function __construct(Vertex $vertex, IteratorAggregate $edges)
    {
        $this->vertex = $vertex;
        $this->edges = $edges;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
    }

    /**
     * Returns an iterator that enumerates the elements of this aggregate.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new Vertex_Iterator(
            $this->vertex, $this->edges->getIterator());
    }
}

//{
/**
 * Represents a vertex in a graph.
 *
 * @package Opus11
 */
class Vertex
    extends AbstractComparable
    implements IVertex
{
    /**
     * @var object AbstractGraph The graph with which this edge is associated.
     */
    protected $graph = NULL;

    /**
     * @var integer The number of this vertex.
     */
    protected $number = 0;
    /**
     * @var mixed The weight associated with this vertex.
     */
    protected $weight = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

    /**
     * Constructs a Vertex with
     * the specified number and weight.
     *
     * @param object AbstractGraph $graph
     * The graph with which this vertex is associated.
     * @param integer $number The specified number.
     * @param mixed $weight The specified weight.
     */
    public function __construct(AbstractGraph $graph, $number, $weight = NULL)
    {
        parent::__construct();
        $this->graph = $graph;
        $this->number = $number;
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
     * Returns the number of this vertex.
     *
     * @return integer The number of this vertex.
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Returns the weight associated with this vertex.
     *
     * @return mixed The weight associated with this vertex.
     */
    public function getWeight()
    {
        return $this->weight;
    }
    
    /**
     * Compares this vertex with a specified comparable object.
     * This method is not implemented yet.
     */
    protected function compareTo(IComparable $obj)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Returns a hashcode for this vertex.
     *
     * @return A hashcode for this vertex.
     */
    public function getHashCode()
    {
        $result = $this->number;
        if ($this->weight !== NULL)
            $result += $weight->getHashCode();
        return $result;
    }
    
    /**
     * Returns a textual representation of this vertex.
     *
     * @return string A string.
     */
    public function __toString()
    {
        $s = '';
        $s .= 'Vertex{' . str($this->number);
        if ($this->weight !== NULL)
            $s .= ', weight = ' . str($this->weight);
        $s .= '}';
        return $s;
    }

    /**
     * Returns the edges in this graph
     * that are incident upon this vertex.
     *
     * @return object IteratorAggregate The edges in this graph
     * that are incident upon this vertex.
     */
    public function getIncidentEdges()
    {
        return $this->graph->getIncidentEdges($this->number);
    }

    /**
     * Returns the edges in this graph
     * that emanate from this vertex.
     *
     * @return object Iterator Aggreate The edges in this graph
     * that emanate from this vertex.
     */
    public function getEmanatingEdges()
    {
        return $this->graph->getEmanatingEdges($this->number);
    }
    
    /**
     * Returns the vertices in this graph
     * which are predecessors of this vertex.
     *
     * @return object IteratorAggregate
     * The vertices in this graph which are predecessors of this vertex.
     */
    public function getPredecessors()
    {
        return new Vertex_IteratorAggregate(
            $this, $this->getIncidentEdges());
    }

    /**
     * Returns the vertices in this graph
     * which are successors of this vertex.
     *
     * @return object IteratorAggregate
     * The vertices in this graph which are successors of this vertex.
     */
    public function getSuccessors()
    {
        return new Vertex_IteratorAggregate(
            $this, $this->getEmanatingEdges());
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Vertex main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Vertex::main(array_slice($argv, 1)));
}
?>
