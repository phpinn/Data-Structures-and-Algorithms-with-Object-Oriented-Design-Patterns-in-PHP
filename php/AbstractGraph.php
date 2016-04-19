<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractGraph.php,v 1.6 2005/12/09 01:11:02 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractContainer.php';
require_once 'Opus11/AbstractVisitor.php';
require_once 'Opus11/IGraph.php';
require_once 'Opus11/IDigraph.php';
require_once 'Opus11/Edge.php';
require_once 'Opus11/Vertex.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/QueueAsLinkedList.php';
require_once 'Opus11/CountingVisitor.php';
require_once 'Opus11/PreOrder.php';
require_once 'Opus11/PrintingVisitor.php';
require_once 'Opus11/Exceptions.php';
require_once 'Opus11/Box.php';

/**
 * Visitor used to implement the __toString method.
 *
 * @package Opus11
 */
class AbstractGraph_ToStringVisitor
    extends AbstractVisitor
{
    /**
     * The text.
     */
    protected $text = '';

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Text getter.
     *
     * @return string The text.
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Visits the given object (vertex).
     *
     * @param object IObject $obj An object (vertex).
     */
    public function visit(IObject $obj)
    {
        $this->text .= str($obj) . "\n";
        foreach ($obj->getEmanatingEdges() as $edge)
        {
            $this->text .= "    " . str($edge) . "\n";
        }
    }
}

/**
 * Iterator that enumerates the vertices of a graph.
 *
 * @package Opus11
 */
class AbstractGraph_VertexIterator
    extends AbstractIterator
{
    /**
     * @var object AbstractGraph The graph.
     */
    protected $graph = NULL;
    /**
     * @var integer The current vertex.
     */
    protected $v = 0;

    /**
     * Constructs an AbstractGraph_VertexIterator for the given graph.
     *
     * @param object AbstractGraph $graph This graph.
     */
    public function __construct(AbstractGraph $graph)
    {
        parent::__construct();
        $this->graph = $graph;
        $this->v = 0;
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
        return $this->v < $this->graph->getNumberOfVertices();
    }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
    {
        return $this->v;
    }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        return $this->graph->getVertex($this->v);
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
    {
        ++$this->v;
    }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
    {
        $this->v = 0;
    }
}

/**
 * Aggregate that represents the vertices of a graph.
 *
 * @package Opus11
 */
class AbstractGraph_VertexAggregate
    implements IteratorAggregate
{
    /**
     * @var object AbstractGraph The graph.
     */
    protected $graph = NULL;

    /**
     * Constructs an AbstractGraph_VertexAggregate for the given graph.
     *
     * @var object AbstractGraph The graph.
     */
    public function __construct(AbstractGraph $graph)
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
     * Returns an iterator that enumerates the vertices of the graph.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return $this->graph->getIterator();
    }
}

//{
/**
 * Abstract base class from which all graph classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractGraph
    extends AbstractContainer
    implements IGraph
{
    /**
     * @var integer The number of vertices in this graph.
     */
    protected $numberOfVertices = 0;
    /**
     * @var integer The number of edges in this graph.
     */
    protected $numberOfEdges = 0;
    /**
     * @var object BasicArray The vertices.
     */
    protected $vertex = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs an AbstractGraph with the specified size.
     *
     * @param integer $size The maximum number of vertices.
     */
    public function __construct($size)
    {
        parent::__construct();
        $this->numberOfVertices = 0;
        $this->numberOfEdges = 0;
        $this->vertex = new BasicArray($size);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->vertex = NULL;
        parent::__destruct();
    }

    /**
     * Returns the edges incident upon the specified vertex.
     *
     * @param integer $v The number of the specified vertex.
     * @return object IteratorAggregate
     * The edges incident upon the specified vertex.
     */
    public abstract function getIncidentEdges($v);

    /**
     * Returns the edges that emanate from the specified vertex.
     *
     * @param integer $v The number of the specified vertex.
     * @return object IteratorAggregate
     * The edges that emanate from the specified vertex.
     */
    public abstract function getEmanatingEdges($v);
//}>a

    /**
     * Purges the vertices from this graph.
     */
    public function purge()
    {
        for ($i = 0; $i < $this->numberOfVertices; ++$i)
            $this->vertex[$i] = NULL;
        $this->numberOfVertices = 0;
        $this->numberOfEdges = 0;
    }

    /**
     * Inserts the given vertex into this graph.
     *
     * @param object Vertex $v The vertex to insert.
     */
    protected function insertVertex(Vertex $v)
    {
        if ($this->numberOfVertices == $this->vertex->getLength())
            throw new ContainerFullException();
        if ($v->getNumber() != $this->numberOfVertices)
            throw new ArgumentError();
        $this->vertex[$this->numberOfVertices] = $v;
        ++$this->numberOfVertices;
    }

    /**
     * Adds a vertex to this graph with the specified number and weight.
     *
     * @param integer $v The number of the vertex to be added.
     * @param mixed $weight The weight to be associated with this vertex.
     */
    public function addVertex($v, $weight = NULL)
    {
        $this->insertVertex(new Vertex($this, $v, $weight));
    }

    /**
     * Returns the vertex with the specified vertex number.
     *
     * @param integer $v The vertex number.
     * @return The vertex with the specified vertex number.
     */
    public function getVertex($v)
    {
        if ($v < 0 || $v >= $this->numberOfVertices)
            throw new IndexError();
        return $this->vertex[$v];
    }

    /**
     * Returns the vertices in this graph.
     *
     * @return object IteratorAggregate The vertices in this graph.
     */
    public function getVertices()
    {
        return new AbstractGraph_VertexAggregate($this);
    }

    /**
     * Inserts an edge into this graph.
     *
     * @param object Edge $edge The edge to be insert into this graph.
     */
    protected abstract function insertEdge(Edge $edge);

    /**
     * Tests whether this graph is a directed graph.
     * A graph is a directed graph
     * if it implements the <code>Digraph</code> interface.
     *
     * @return True if this graph is a directed graph.
     */
    public function isDirected()
    {
        return $this instanceof IDigraph;
    }

    /**
     * Adds an edge to this graph that connects the specified vertices
     * and has the specified weight.
     *
     * @param integer $v
     * The number of the vertex from which the edge emanates.
     * @param integer $w
     * The number of the vertex upon which the edge is incident.
     * @param mixed $weight The weight associated with the edge.
     */
    public function addEdge($v, $w, $weight = NULL)
    {
        $this->insertEdge(new Edge($this, $v, $w, $weight));
    }

    /**
     * Returns the number of vertices in this graph.
     *
     * @return integer The number of vertices in this graph.
     */
    public function getNumberOfVertices()
    {
        return $this->numberOfVertices;
    }

    /**
     * Returns the number of edges in this graph.
     *
     * @return integer The number of edges in this graph.
     */
    public function getNumberOfEdges()
    {
        return $this->numberOfEdges;
    }

    /**
     * Accepts a visitor and makes it visit the vertices in this graph.
     *
     * @param object IVisitor $visitor The visitor to accept.
     */
    public function accept(IVisitor $visitor)
    {
        for ($v = 0; $v < $this->numberOfVertices; ++$v)
        {
            if ($visitor->isDone())
                break;
            $visitor->visit($this->vertex[$v]);
        }
    }

    /**
     * Returns a value computed by calling the given callback function
     * for each item in this container.
     * Each time the callback function will be called with two arguments:
     * The first argument is the next item in this container.
     * The first time the callback function is called,
     * the second argument is the given initial value.
     * On subsequent calls to the callback function,
     * the second argument is the result returned from
     * the previous call to the callback function.
     *
     * @param callback $callback A callback function.
     * @param mixed $initialState The initial state.
     * @return mixed The value returned by
     * the last call to the callback function.
     */
    public function reduce($callback, $initialState)
    {
        return $this->vertex->reduce($callback, $initialState);
    }

//{
    /**
     * Causes a visitor to visit the vertices of this graph
     * in depth-first traversal order starting from a given vertex.
     * This method invokes the preVisit
     * and postVisit methods of the visitor
     * for each vertex in this graph.
     * The default implementation is recursive.
     * The default implementation never invokes
     * the inVisit method of the visitor.
     * The traversal continues as long as the isDone
     * method of the visitor returns false.
     *
     * @param object IPrePostVisitor $visitor The visitor to accept.
     * @param integer $start The vertex at which to start the traversal.
     */
    public function depthFirstTraversal(
        IPrePostVisitor $visitor, $start)
    {
        $visited = new BasicArray($this->numberOfVertices);
        for ($v = 0; $v < $this->numberOfVertices; ++$v)
            $visited[$v] = false;
        $this->doDepthFirstTraversal(
            $visitor, $this->vertex[$start], $visited);
    }

/**
 * Recursive depth-first traversal method.
     *
     * @param object IPrePostVisitor $visitor The visitor to accept.
     * @param integer $start The vertex at which to start the traversal.
     * @param object BasicArray $visited
     * Used to keep track of the visited vertices.
     */
    private function doDepthFirstTraversal(
        IPrePostVisitor $visitor, $v, $visited)
    {
        if ($visitor->isDone())
            return;
        $visitor->preVisit($v);
        $visited[$v->getNumber()] = true;
        foreach ($v->getSuccessors() as $to)
        {
            if (!$visited[$to->getNumber()])
            {
                $this->doDepthFirstTraversal(
                    $visitor, $to, $visited);
            }
        }
        $visitor->postVisit($v);
    }
//}>b

//{
    /**
     * Causes a visitor to visit the vertices of this directed graph
     * in breadth-first traversal order starting from a given vertex.
     * This method invokes the visit method of the visitor
     * for each vertex in this graph.
     * The default implementation is iterative and uses a queue
     * to keep track of the vertices to be visited.
     * The traversal continues as long as the isDone
     * method of the visitor returns false.
     *
     * @param object IVisitor $visitor The visitor to accept.
     * @param integer $start The vertex at which to start the traversal.
     */
    public function breadthFirstTraversal(
        IVisitor $visitor, $start)
    {
        $enqueued = new BasicArray($this->numberOfVertices);
        for ($v = 0; $v < $this->numberOfVertices; ++$v)
            $enqueued[$v] = false;

        $queue = new QueueAsLinkedList();

        $enqueued[$start] = true;
        $queue->enqueue($this->vertex[$start]);
        while (!$queue->isEmpty() && !$visitor->isDone())
        {
            $v = $queue->dequeue();
            $visitor->visit($v);
            foreach ($v->getSuccessors() as $to)
            {
                if (!$enqueued[$to->getNumber()])
                {
                    $enqueued[$to->getNumber()] = true;
                    $queue->enqueue($to);
                }
            }
        }
    }
//}>c

//{
    /**
     * Causes a visitor to visit the vertices of this graph
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
    public function topologicalOrderTraversal(IVisitor $visitor)
    {
        $inDegree = new BasicArray($this->numberOfVertices);
        for ($v = 0; $v < $this->numberOfVertices; ++$v)
            $inDegree[$v] = 0;
        foreach ($this->getEdges() as $edge)
        {
            $to = $edge->getV1();
            $inDegree[$to->getNumber()] += 1;
        }

        $queue = new QueueAsLinkedList();
        for ($v = 0; $v < $this->numberOfVertices; ++$v)
            if ($inDegree[$v] == 0)
                $queue->enqueue($this->vertex[$v]);
        while (!$queue->isEmpty() && !$visitor->isDone())
        {
            $v = $queue->dequeue();
            $visitor->visit($v);
            foreach ($v->getSuccessors() as $to)
            {
                $inDegree[$to->getNumber()] -= 1;
                if ($inDegree[$to->getNumber()] == 0)
                    $queue->enqueue($to);
            }
        }
    }
//}>d

    /**
     * Returns a textual representation of this graph.
     *
     * @return string A string.
     */
    public function __toString()
    {
        $visitor = new AbstractGraph_ToStringVisitor();
        $this->accept($visitor);
        return $this->getClass()->getName() .
            "{\n" . $visitor->getText() . "}";
    }

//{
    /**
     * Tests whether this graph is connected.
     * The default implementation does a depth-first traversal
     * and counts the number of vertices visited.
     * If all the vertices are visited, the graph is connected.
     *
     * @return boolean True if this graph is connected; false otherwise.
     */
    public function isConnected()
    {
        $visitor = new CountingVisitor();
        $this->depthFirstTraversal(new PreOrder($visitor), 0);
        return $visitor->getCount() == $this->numberOfVertices;
    }
//}>e

//{
    /**
     * Tests whether this graph is strongly connected.
     * The default implementation does a depth-first traversal
     * starting at each vertex in this graph.
     * If every traversal visits all the vertices in this graph,
     * the graph is strongly connected.
     *
     * @return boolean 
     * True if this graph is strongly connected; false otherwise.
     */
    public function isStronglyConnected()
    {
        $visitor = new CountingVisitor();
        for ($v = 0; $v < $this->numberOfVertices; ++$v)
        {
            $visitor->setCount(0);
            $this->depthFirstTraversal(
                new PreOrder($visitor), $v);
            if ($visitor->getCount() != $this->numberOfVertices)
                return false;
        }
        return true;
    }
//}>f

//{
    /**
     * Tests whether this graph is cyclic.
     * The default implementation does a topological order traversal
     * and counts the number of vertices visited.
     * If every vertex in this graph is visited,
     * the graph is acyclic.
     *
     * @return True if this graph is cyclic; false otherwise.
     */
    public function isCyclic()
    {
        $visitor = new CountingVisitor();
        $this->topologicalOrderTraversal($visitor);
        return $visitor->getCount() != $this->numberOfVertices;
    }
//}>g

    /**
     * Returns an iterator that enumerates the vertices of this graph.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new AbstractGraph_VertexIterator($this);
    }

    /**
     * Graph test method.
     *
     * @param object IGraph $g The graph to test.
     */
    public static function test(IGraph $g)
    {
        printf("Graph test program.\n");
        $g->addVertex(0);
        $g->addVertex(1);
        $g->addVertex(2);
        $g->addEdge(0, 1);
        $g->addEdge(0, 2);
        $g->addEdge(1, 2);
        printf("%s\n", str($g));
        printf("isDirected returns %s\n", str($g->isDirected()));
        printf("Using vertex iterator\n");
        foreach ($g->getVertices() as $v)
        {
            printf("%s\n", str($v));
        }
        printf("Using edge iterator\n");
        foreach ($g->getEdges() as $e)
        {
            printf("%s\n", str($e));
        }

        printf("DepthFirstTraversal\n");
        $g->depthFirstTraversal(new PreOrder(new PrintingVisitor(STDOUT)), 0);

        printf("BreadthFirstTraversal\n");
        $g->breadthFirstTraversal(new PrintingVisitor(STDOUT), 0);

        printf("isConnected returns %s\n", str($g->isConnected()));
    }

    /**
     * Weighted graph test method.
     *
     * @param object IGraph $g The weighted graph to test.
     */
    public static function testWeighted(IGraph $g)
    {
        printf("Weighted graph test program.\n");
        $g->addVertex(0, box(123));
        $g->addVertex(1, box(234));
        $g->addVertex(2, box(345));
        $g->addEdge(0, 1, box(3));
        $g->addEdge(0, 2, box(1));
        $g->addEdge(1, 2, box(4));
        printf("%s\n", str($g));
        printf("Using vertex iterator\n");
        foreach ($g->getVertices() as $v)
        {
            printf("%s\n", str($v));
        }
        printf("Using edge iterator\n");
        foreach ($g->getEdges() as $e)
        {
            printf("%s\n", str($e));
        }
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractGraph main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractGraph::main(array_slice($argv, 1)));
}
?>
