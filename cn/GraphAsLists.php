<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: GraphAsLists.php,v 1.4 2005/12/09 01:11:12 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractGraph.php';
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/LinkedList.php';
require_once 'Opus11/Exceptions.php';

/**
 * Iterator that enumerates the edges of a GraphAsLists.
 *
 * @package Opus11
 */
class GraphAsLists_EdgeIterator
    extends AbstractIterator
{
    /**
     * @var object GraphAsLists The graph.
     */
    protected $graph = NULL;
    /**
     * @var integer The current row.
     */
    protected $v = 0;
    /**
     * @var object LinkedList_Element The current item.
     */
    protected $ptr = NULL;
    /**
     * @var integer The position in the adjacency list.
     */
    protected $pos = 0;

    /**
     * Constructs a GraphAsLists_EdgeIterator for the given graph.
     *
     * @param object GraphAsLists $graph The graph.
     */
    public function __construct(GraphAsLists $graph)
    {
        parent::__construct();
        $this->graph = $graph;
        $list = $this->graph->getAdjacencyList();
        for ($this->v = 0;
            $this->v < $this->graph->getNumberOfVertices(); ++$this->v)
        {
            $this->ptr = $list[$this->v]->getHead();
            $this->pos = 0;
            if ($this->ptr !== NULL)
                break;
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->graph = NULL;
        $this->ptr = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
    {
        return $this->ptr !== NULL;
    }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
    {
        return $this->v * $this->graph->getNumberOfVertices() + $this->pos;
    }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        return $this->ptr->getDatum();
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        $this->ptr = $this->ptr->getNext();
        $this->pos += 1;
        if ($this->ptr !== NULL)
            return;
        $list = $this->graph->getAdjacencyList();
        for (++$this->v;
            $this->v < $this->graph->getNumberOfVertices(); ++$this->v)
        {
            $this->ptr = $list[$this->v]->getHead();
            $this->pos = 0;
            if ($this->ptr !== NULL)
                break;
        }
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $list = $this->graph->getAdjacencyList();
        for ($this->v = 0;
            $this->v < $this->graph->getNumberOfVertices(); ++$this->v)
        {
            $this->ptr = $list[$this->v]->getHead();
            $this->pos = 0;
            if ($this->ptr !== NULL)
                break;
        }
    }
}

/**
 * Aggregate that represents the edges of a GraphAsLists.
 *
 * @package Opus11
 */
class GraphAsLists_EdgeAggregate
    implements IteratorAggregate
{
    /**
     * @var object GraphAsLists The graph.
     */
    protected $graph = NULL;

    /**
     * Constructs a GraphAsLists_EdgeAggregate for the given graph.
     *
     * @param object GraphAsLists $graph The graph.
     */
    public function __construct(GraphAsLists $graph)
    {
        $this->graph = $graph;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->graph = NULL;
    }

    /**
     * Returns an iterator the enumerates the edges of the graph.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new GraphAsLists_EdgeIterator($this->graph);
    }
}

/**
 * Iterator that enumerates the emanating edges of a given vertex
 * in a GraphAsLists.
 *
 * @package Opus11
 */
class GraphAsLists_EmanatingEdgeIterator
    extends AbstractIterator
{
    /**
     * @var object GraphAsLists The graph.
     */
    protected $graph = NULL;
    /**
     * @var integer The current row.
     */
    protected $v = 0;
    /**
     * @var object LinkedList_Element The current item.
     */
    protected $ptr = NULL;
    /**
     * @var integer The position in the adjacency list.
     */
    protected $pos = 0;

    /**
     * Constructs a GraphAsLists_EmanatingEdgeIterator
     * for the given graph and vertex.
     *
     * @param object GraphAsLists $graph The graph.
     * @param integer $v The vertex.
     */
    public function __construct(GraphAsLists $graph, $v)
    {
        parent::__construct();
        $this->graph = $graph;
        $this->v = $v;
        $list = $this->graph->getAdjacencyList();
        $this->ptr = $list[$this->v]->getHead();
        $this->pos = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->graph = NULL;
        $this->ptr = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
    {
        return $this->ptr !== NULL;
    }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
    {
        return $this->v * $this->graph->getNumberOfVertices() + $this->pos;
    }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        return $this->ptr->getDatum();
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        $this->ptr = $this->ptr->getNext();
        $this->pos += 1;
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $list = $this->graph->getAdjacencyList();
        $this->ptr = $list[$this->v]->getHead();
        $this->pos = 0;
    }
}

/**
 * Aggregate that represents the emanating edges
 * of a given vertex of a GraphAsLists.
 *
 * @package Opus11
 */
class GraphAsLists_EmanatingEdgeAggregate
    implements IteratorAggregate
{
    /**
     * @var object GraphAsLists The graph.
     */
    protected $graph = NULL;
    /**
     * @var integer The vertex.
     */
    protected $v = 0;

    /**
     * Constructs a GraphAsLists_EmanatingEdgeAggregate
     * for the given graph and vertex.
     *
     * @param object GraphAsLists $graph The graph.
     * @param integer $v The vertex.
     */
    public function __construct(GraphAsLists $graph, $v)
    {
        $this->graph = $graph;
        $this->v = $v;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->graph = NULL;
    }

    /**
     * Returns an iterator the enumerates the emanating edges
     * of the given vertex of the graph.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new GraphAsLists_EmanatingEdgeIterator($this->graph, $this->v);
    }
}

//{
/**
 * An undirected graph implemented using adjacency lists.
 *
 * @package Opus11
 */
class GraphAsLists
    extends AbstractGraph
{
    /**
     * @var object BasicArray The array of adjacency lists.
     */
    protected $adjacencyList = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a GraphAsLists with the specified size.
     *
     * @param size The maximum number of vertices.
     */
    public function __construct($size = 0)
    {
        parent::__construct($size);
        $this->adjacencyList = new BasicArray($size);
        for ($i = 0; $i < $size; ++$i)
            $this->adjacencyList[$i] = new LinkedList();
    }
//}>a

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->adjacencyList = NULL;
        parent::__destruct();
    }

    /**
     * Adjacency list array getter.
     */
    public function & getAdjacencyList()
    {
        return $this->adjacencyList;
    }

    /**
     * Purges this graph, making it the empty graph.
     */
    public function purge()
    {
        for ($i = 0; $i < $this->numberOfVertices; ++$i)
            $this->adjacencyList[$i]->purge();
        parent::purge();
    }

    /**
     * Inserts the specified edge into this graph.
     *
     * @param object Edge $edge The edge to insert into this graph.
     */
    protected function insertEdge(Edge $edge)
    {
        $v = $edge->getV0()->getNumber();
        $this->adjacencyList[$v]->append($edge);
        /*
        $w = $edge->getV1()->getNumber();
        $this->adjacencyList[$w]->append(
            new Edge($this, $w, $v, $edge->getWeight()));
        */
        ++$this->numberOfEdges;
    }

    /**
     * Returns the edge in this graph that connects the specified vertices.
     *
     * @param integer $v A vertex number.
     * @param integer $w A vertex number.
     * @return object Edge
     * The edge in this graph that connects the specified vertices.
     */
    public function getEdge($v, $w)
    {
        if ($v < 0 || $v >= $this->numberOfVertices)
            throw new IndexError();
        if ($w < 0 || $w >= $this->numberOfVertices)
            throw new IndexError();
        for ($ptr = $this->adjacencyList[$v]->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            $edge = $ptr->getDatum();
            if ($edge->getV1()->getNumber() == $w)
                return $edge;
        }
        throw new ArgumentError();
    }

    /**
     * Tests whethere there is an edge in this graph
     * that connects the specified vertices.
     *
     * @param integer $v A vertex number.
     * @param integer $w A vertex number.
     * @return boolean True if there is an edge in this graph
     * that connects the specified vertices; false otherwise.
     */
    public function isEdge($v, $w)
    {
        if ($v < 0 || $v >= $this->numberOfVertices)
            throw new IndexError();
        if ($w < 0 || $w >= $this->numberOfVertices)
            throw new IndexError();
        for ($ptr = $this->adjacencyList[$v]->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            $edge = $ptr->getDatum();
            if ($edge->getV1()->getNumber() == $w)
                return true;
        }
        return false;
    }

    /**
     * Returns the edges in this graph.
     *
     * @return object IteratorAggregate
     * The edges in this graph.
     */
    public function getEdges()
    {
        return new GraphAsLists_EdgeAggregate($this);
    }

    /**
     * Returns the edges that emanate from the specified vertex.
     *
     * @param integer $v A vertex.
     * @return object IteratorAggregate
     * The edges that emanate from the specified vertex.
     */
    public function getEmanatingEdges($v)
    {
        return new GraphAsLists_EmanatingEdgeAggregate($this, $v);
    }

    /**
     * Returns the edges that are incident upon the specified vertex.
     *
     * @param integer $v A vertex.
     * @return object IteratorAggregate
     * The edges that are incident upon the specified vertex.
     */
    public function getIncidentEdges($w)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Compares this graph with the specified comparable object.
     * This method is not implemented.
     *
     * @param object IComparable $arg
     * The object with which to compare this graph.
     */
    protected function compareTo(IComparable $arg)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("GraphAsLists main program.\n");
        $status = 0;
        $g = new GraphAsLists(4);
        AbstractGraph::test($g);
        $g->purge();
        AbstractGraph::testWeighted($g);
        $g->purge();
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(GraphAsLists::main(array_slice($argv, 1)));
}
?>
