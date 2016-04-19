<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: GraphAsMatrix.php,v 1.4 2005/12/09 01:11:12 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractGraph.php';
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/DenseMatrix.php';
require_once 'Opus11/Exceptions.php';

/**
 * Iterator that enumerates the edges of a GraphAsMatrix.
 *
 * @package Opus11
 */
class GraphAsMatrix_EdgeIterator
    extends AbstractIterator
{
    /**
     * @var object GraphAsMatrix The graph.
     */
    protected $graph = NULL;
    /**
     * @var integer The current row.
     */
    protected $v = 0;
    /**
     * @var integer The current column.
     */
    protected $w = 0;

    /**
     * Constructs a GraphAsMatrix_EdgeIterator for the given graph.
     *
     * @param object GraphAsMatrix $graph The graph.
     */
    public function __construct(GraphAsMatrix $graph)
    {
        parent::__construct();
        $this->graph = $graph;
        $matrix = $this->graph->getMatrix();
        for ($this->v = 0;
            $this->v < $this->graph->getNumberOfVertices(); ++$this->v)
        {
            for ($this->w = $this->v + 1;
                $this->w < $this->graph->getNumberOfVertices(); ++$this->w)
            {
                if ($matrix[array($this->v,$this->w)] !== NULL)
                    break 2;
            }
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->graph = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
    {
        return $this->v < $this->graph->getNumberOfVertices() &&
            $this->w < $this->graph->getNumberOfVertices();
    }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
    {
        return $this->v * $this->graph->getNumberOfVertices() + $this->w;
    }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        $matrix = $this->graph->getMatrix();
        return $matrix[array($this->v, $this->w)];
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        $matrix = $this->graph->getMatrix();
        for (++$this->w;
            $this->w < $this->graph->getNumberOfVertices(); ++$this->w)
        {
            if ($matrix[array($this->v,$this->w)] !== NULL)
                return;
        }
        for (++$this->v;
            $this->v < $this->graph->getNumberOfVertices(); ++$this->v)
        {
            for ($this->w = $this->v + 1;
                $this->w < $this->graph->getNumberOfVertices(); ++$this->w)
            {
                if ($matrix[array($this->v,$this->w)] !== NULL)
                    return;
            }
        }
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $matrix = $this->graph->getMatrix();
        for ($this->v = 0;
            $this->v < $this->graph->getNumberOfVertices(); ++$this->v)
        {
            for ($this->w = $this->v + 1;
                $this->w < $this->graph->getNumberOfVertices(); ++$this->w)
            {
                if ($matrix[array($this->v,$this->w)] !== NULL)
                    break 2;
            }
        }
    }
}

/**
 * Aggregate that represents the edges of a GraphAsMatrix.
 *
 * @package Opus11
 */
class GraphAsMatrix_EdgeAggregate
    implements IteratorAggregate
{
    /**
     * @var object GraphAsMatrix The graph.
     */
    protected $graph = NULL;

    /**
     * Constructs a GraphAsMatrix_EdgeAggregate for the given graph.
     *
     * @param object GraphAsMatrix $graph The graph.
     */
    public function __construct(GraphAsMatrix $graph)
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
        return new GraphAsMatrix_EdgeIterator($this->graph);
    }
}

/**
 * Iterator that enumerates the emanating edges of a given vertex
 * in a GraphAsMatrix.
 *
 * @package Opus11
 */
class GraphAsMatrix_EmanatingEdgeIterator
    extends AbstractIterator
{
    /**
     * @var object GraphAsMatrix The graph.
     */
    protected $graph = NULL;
    /**
     * @var integer The current row.
     */
    protected $v = 0;
    /**
     * @var integer The current column.
     */
    protected $w = 0;

    /**
     * Constructs a GraphAsMatrix_EmanatingEdgeIterator
     * for the given graph and vertex.
     *
     * @param object GraphAsMatrix $graph The graph.
     * @param integer $v The vertex.
     */
    public function __construct(GraphAsMatrix $graph, $v)
    {
        parent::__construct();
        $this->graph = $graph;
        $this->v = $v;
        $matrix = $this->graph->getMatrix();
        for ($this->w = 0;
            $this->w < $this->graph->getNumberOfVertices(); ++$this->w)
        {
            if ($matrix[array($this->v,$this->w)] !== NULL)
                break;
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->graph = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
    {
        return $this->v < $this->graph->getNumberOfVertices() &&
            $this->w < $this->graph->getNumberOfVertices();
    }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
    {
        return $this->v * $this->graph->getNumberOfVertices() + $this->w;
    }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        $matrix = $this->graph->getMatrix();
        return $matrix[array($this->v, $this->w)];
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        $matrix = $this->graph->getMatrix();
        for (++$this->w;
            $this->w < $this->graph->getNumberOfVertices(); ++$this->w)
        {
            if ($matrix[array($this->v,$this->w)] !== NULL)
                break;
        }
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $matrix = $this->graph->getMatrix();
        for ($this->w = 0;
            $this->w < $this->graph->getNumberOfVertices(); ++$this->w)
        {
            if ($matrix[array($this->v,$this->w)] !== NULL)
                break;
        }
    }
}

/**
 * Aggregate that represents the emanating edges
 * of a given vertex of a GraphAsMatrix.
 *
 * @package Opus11
 */
class GraphAsMatrix_EmanatingEdgeAggregate
    implements IteratorAggregate
{
    /**
     * @var object GraphAsMatrix The graph.
     */
    protected $graph = NULL;
    /**
     * @var integer The vertex.
     */
    protected $v = 0;

    /**
     * Constructs a GraphAsMatrix_EmanatingEdgeAggregate
     * for the given graph and vertex.
     *
     * @param object GraphAsMatrix $graph The graph.
     * @param integer $v The vertex.
     */
    public function __construct(GraphAsMatrix $graph, $v)
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
        return new GraphAsMatrix_EmanatingEdgeIterator($this->graph, $this->v);
    }
}

/**
 * Iterator that enumerates the incident edges of a given vertex
 * in a GraphAsMatrix.
 *
 * @package Opus11
 */
class GraphAsMatrix_IncidentEdgeIterator
    extends AbstractIterator
{
    /**
     * @var object GraphAsMatrix The graph.
     */
    protected $graph = NULL;
    /**
     * @var integer The current row.
     */
    protected $v = 0;
    /**
     * @var integer The current column.
     */
    protected $w = 0;

    /**
     * Constructs a GraphAsMatrix_IncidentEdgeIterator
     * for the given graph and vertex.
     *
     * @param object GraphAsMatrix $graph The graph.
     * @param integer $w The vertex.
     */
    public function __construct(GraphAsMatrix $graph, $w)
    {
        parent::__construct();
        $this->graph = $graph;
        $this->w = $w;
        $matrix = $this->graph->getMatrix();
        for ($this->v = 0;
            $this->v < $this->graph->getNumberOfVertices(); ++$this->v)
        {
            if ($matrix[array($this->v,$this->w)] !== NULL)
                break;
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->graph = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
    {
        return $this->v < $this->graph->getNumberOfVertices() &&
            $this->w < $this->graph->getNumberOfVertices();
    }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
    {
        return $this->v * $this->graph->getNumberOfVertices() + $this->w;
    }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        $matrix = $this->graph->getMatrix();
        return $matrix[array($this->v, $this->w)];
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        $matrix = $this->graph->getMatrix();
        for (++$this->v;
            $this->v < $this->graph->getNumberOfVertices(); ++$this->v)
        {
            if ($matrix[array($this->v,$this->w)] !== NULL)
                break;
        }
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $matrix = $this->graph->getMatrix();
        for ($this->v = 0;
            $this->v < $this->graph->getNumberOfVertices(); ++$this->v)
        {
            if ($matrix[array($this->v,$this->w)] !== NULL)
                break;
        }
    }
}

/**
 * Aggregate that represents the incident edges
 * of a given vertex of a GraphAsMatrix.
 *
 * @package Opus11
 */
class GraphAsMatrix_IncidentEdgeAggregate
    implements IteratorAggregate
{
    /**
     * @var object GraphAsMatrix The graph.
     */
    protected $graph = NULL;
    /**
     * @var integer The vertex.
     */
    protected $w = 0;

    /**
     * Constructs a GraphAsMatrix_IncidentEdgeAggregate
     * for the given graph and vertex.
     *
     * @param object GraphAsMatrix $graph The graph.
     * @param integer $w The vertex.
     */
    public function __construct(GraphAsMatrix $graph, $w)
    {
        $this->graph = $graph;
        $this->w = $w;
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
        return new GraphAsMatrix_IncidentEdgeIterator($this->graph, $this->w);
    }
}

//{
/**
 * An undirected graph implemented using an adjacency matrix.
 *
 * @package Opus11
 */
class GraphAsMatrix
    extends AbstractGraph
{
    /**
     * @var object DenseMatrix The adjacency matrix.
     */
    protected $matrix = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a GraphAsMatrix with the specified size.
     *
     * @param size The maximum number of vertices.
     */
    public function __construct($size = 0)
    {
        parent::__construct($size);
        $this->matrix = new DenseMatrix($size, $size);
    }
//}>a

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->matrix = NULL;
        parent::__destruct();
    }

    /**
     * Matrix getter.
     */
    public function & getMatrix()
    {
        return $this->matrix;
    }

    /**
     * Purges this graph, making it the empty graph.
     */
    public function purge()
    {
        for ($i = 0; $i < $this->numberOfVertices; ++$i)
            for ($j = 0; $j < $this->numberOfVertices; ++$j)
                $this->matrix[array($i,$j)] = NULL;
        parent::purge();
    }

    /**
     * Inserts the given edge into this graph.
     *
     * @param object Edge $edge The edge to insert.
     */
    protected function insertEdge(Edge $edge)
    {
        $v = $edge->getV0()->getNumber();
        $w = $edge->getV1()->getNumber();
        if ($this->matrix[array($v,$w)] !== NULL)
            throw new ArgumentError();
        if ($v == $w)
            throw new ArgumentError();
        $this->matrix[array($v,$w)] = $edge;
        $this->matrix[array($w,$v)] = $edge;
        ++$this->numberOfEdges;
    }

    /**
     * Returns the edge that connects the specified vertices.
     *
     * @param integer $v A vertex number.
     * @param integer $w A vertex number.
     * @return object Edge The edge that connects the specified vertices.
     */
    public function getEdge($v, $w)
    {
        if ($v < 0 || $v >= $this->numberOfVertices)
            throw new IndexError();
        if ($w < 0 || $w >= $this->numberOfVertices)
            throw new IndexError();
        if ($this->matrix[array($v,$w)] === NULL)
            throw new ArgumentError();
        return $this->matrix[array($v,$w)];
    }

    /**
     * Tests whether there is an edge in this graph
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
        return $this->matrix[array($v,$w)] !== NULL;
    }

    /**
     * Returns the edges in this graph.
     *
     * @return object IteratorAggregate
     * The edges in this graph.
     */
    public function getEdges()
    {
        return new GraphAsMatrix_EdgeAggregate($this);
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
        return new GraphAsMatrix_EmanatingEdgeAggregate($this, $v);
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
        return new GraphAsMatrix_IncidentEdgeAggregate($this, $w);
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
        printf("GraphAsMatrix main program.\n");
        $status = 0;
        $g = new GraphAsMatrix(4);
        AbstractGraph::test($g);
        $g->purge();
        AbstractGraph::testWeighted($g);
        $g->purge();
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(GraphAsMatrix::main(array_slice($argv, 1)));
}
?>
