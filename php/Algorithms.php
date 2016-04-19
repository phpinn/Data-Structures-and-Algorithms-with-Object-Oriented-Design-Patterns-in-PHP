<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Algorithms.php,v 1.20 2005/12/09 01:11:05 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/DenseMatrix.php';
require_once 'Opus11/StackAsLinkedList.php';
require_once 'Opus11/QueueAsLinkedList.php';
require_once 'Opus11/ChainedHashTable.php';
require_once 'Opus11/PartitionAsForest.php';
require_once 'Opus11/AVLTree.php';
require_once 'Opus11/IDigraph.php';
require_once 'Opus11/BinaryHeap.php';
require_once 'Opus11/PartitionAsForest.php';
require_once 'Opus11/GraphAsMatrix.php';
require_once 'Opus11/GraphAsLists.php';
require_once 'Opus11/DigraphAsMatrix.php';
require_once 'Opus11/DigraphAsLists.php';
require_once 'Opus11/AbstractVisitor.php';
require_once 'Opus11/Association.php';
require_once 'Opus11/Box.php';
require_once 'Opus11/Limits.php';

//{
/**
 * Data structure used both in Dijkstra's algorithm and Prim's algorithm.
 *
 * @package Opus11
 */
class Algorithms_Entry
{
    /**
     * @var boolean Is the shortest path for this vertex known?
     */
    public $known = false;
    /**
     * @var integer The length of the current shortest path.
     */
    public $distance = Limits::MAXINT;
    /**
     * @var integer The predecessor of this vertex on the shortest path.
     */
    public $predecessor = -1;
}
//}>g

//{
    /**
     * Used by the critical path analysis method
     * to compute the earliest completion time for each event.
     *
     * @package Opus11
     */
    class EarliestTimeVisitor
        extends AbstractVisitor
    {
        /**
         * @var object BasicArray Earliest times.
         */
        protected $earliestTime = NULL;

        /**
         * Constructs an earliest time visitor that fills the given array.
         *
         * @param object BasicArray $earliestTime Earliest times array.
         */
        public function __construct($earliestTime)
        {
            parent::__construct();
            $this->earliestTime = $earliestTime;
        }

        /**
         * Destructor.
         */
        public function __destruct()
        {
            $this->earliestTime = NULL;
            parent::__destruct();
        }

        /**
         * Visits the given object.
         *
         * @param object IObject $w An object.
         */
        public function visit(IObject $w)
        {
            $max = $this->earliestTime[0];
            foreach ($w->getIncidentEdges() as $edge)
            {
                $v = $edge->getV0();
                $wt = $edge->getWeight();
                $max = max($max, $this->earliestTime[
                    $v->getNumber()] + unbox($wt));
            }
            $this->earliestTime[$w->getNumber()] = $max;
        }
    }
//}>i

    /**
     * Used by the critical path analysis method
     * to compute the latest completion time for each event.
     *
     * @package Opus11
     */
    class LatestTimeVisitor
        extends AbstractVisitor
    {
        /**
         * @var object BasicArray Latest times.
         */
        protected $latestTime = NULL;

        /**
         * Constructs an latest time visitor that fills the given array.
         *
         * @param object BasicArray $latestTime Latest times array.
         */
        public function __construct($latestTime)
        {
            parent::__construct();
            $this->latestTime = $latestTime;
        }

        /**
         * Destructor.
         */
        public function __destruct()
        {
            $this->latestTime = NULL;
            parent::__destruct();
        }

        /**
         * Visits the given object.
         *
         * @param object IObject $w An object.
         */
        public function visit(IObject $v)
        {
            $min = $this->latestTime[$this->latestTime->getLength() - 1];
            foreach ($v->getEmanatingEdges() as $edge)
            {
                $w = $edge->getV1();
                $wt = $edge->getWeight();
                $min = min($min,
                    $this->latestTime[$w->getNumber()] - unbox($wt));
            }
            $this->latestTime[$v->getNumber()] = $min;
        }
    }

//{
/**
 * Provides various algorithms.
 *
 * @package Opus11
 */
class Algorithms
{
//}@head

//{
//!}
//}@tail

//{
    /**
     * Traverses a tree breadth-first, printing each node as it is visited.
     * Uses a queue to keep track of the nodes to be visited.
     *
     * @param object ITree $tree The tree to traverse.
     */
    public static function breadthFirstTraversal(ITree $tree)
    {
        $queue = new QueueAsLinkedList();
        if (!$tree->isEmpty ())
            $queue->enqueue($tree);
        while (!$queue->isEmpty())
        {
            $t = $queue->dequeue();
            printf("%s\n", str($t->getKey()));
            for ($i = 0; $i < $t->getDegree(); ++$i)
            {
                $subTree = $t->getSubtree($i);
                if (!$subTree->isEmpty())
                {
                    $queue->enqueue($subTree);
                }
            }
        }
    }
//}>a

//{
    /**
     * Computes equivalence classes using a partition.
     * First reads an integer from the input stream that
     * specifies the size of the universal set.
     * Then reads pairs of integers from the input stream
     * that denote equivalent items in the universal set.
     * Prints the partition on end-of-file.
     *
     * @param resource $in The input stream.
     * @param resource $out The output stream.
     */
    public static function equivalenceClasses($in, $out)
    {
        if (($line = fgets($in)) == false)
            return;
        $n = intval($line);
        $p = new PartitionAsForest($n);

        for (;;)
        {
            if (($line = fgets($in)) == false)
                break;
            $i = intval($line);
            if (($line = fgets($in)) == false)
                break;
            $j = intval($line);
            $s = $p->findItem($i);
            $t = $p->findItem($j);
            if ($s !== $t)
                $p->join($s, $t);
            else
                printf("redundant pair: %d, %d\n", $i, $j);
        }
        printf("%s\n", str($p));
    }
//}>b

//{
    /**
     * Dijkstra's algorithm to solve the single-source, shortest path problem
     * for the given edge-weighted, directed graph.
     * The graph must not contain any negative cost cycles.
     *
     * @param object IDigraph $g An edge-weighted, directed graph.
     * It is assumed that the edge weights are BoxedIntegers.
     * @param integer $s The start vertex in the graph.
     * @return object IDigraph A vertex-weighted, directed graph.
     * The weight on a vertex denotes the length of the shortest path
     * to the start vertex.
     * The one edge that emanates from a vertex connects that vertex
     * to its predecessor on the shortest path to the start vertex.
     */
    public function dijkstrasAlgorithm(IDigraph $g, $s)
    {
        $n = $g->getNumberOfVertices();
        $table = new BasicArray($n);
        for ($v = 0; $v < $n; ++$v)
            $table[$v] = new Algorithms_Entry();
        $table[$s]->distance = 0;
        $queue = new BinaryHeap($g->getNumberOfEdges());
        $queue->enqueue (
            new Association(box(0), $g->getVertex($s)));
        while (!$queue->isEmpty())
        {
            $assoc = $queue->dequeueMin();
            $v0 = $assoc->getValue();
            $n0 = $v0->getNumber();
            if (!$table[$n0]->known)
            {
                $table[$n0]->known = true;
                foreach ($v0->getEmanatingEdges() as $edge)
                {
                    $v1 = $edge->getMate($v0);
                    $n1 = $v1->getNumber();
                    $wt = $edge->getWeight();
                    $d = $table[$n0]->distance + unbox($wt);
                    if ($table[$n1]->distance > $d)
                    {
                        $table[$n1]->distance = $d;
                        $table[$n1]->predecessor = $n0;
                        $queue->enqueue(
                            new Association(box($d), $v1));
                    }
                }
            }
        }
        $result = new DigraphAsLists($n);
        for ($v = 0; $v < $n; ++$v)
            $result->addVertex($v, box($table[$v]->distance));
        for ($v = 0; $v < $n; ++$v)
            if ($v != $s)
                $result->addEdge($v, $table[$v]->predecessor);
        return $result;
    }
//}>c

//{
    /**
     * Floyd's algorithm to solve the all-pairs, shortest path problem
     * for the given edge-weighted, directed graph.
     *
     * @param object IDigraph $g An edge-weighted, directed graph.
     * It is assumed that the edge weights are BoxedIntegers.
     * @return object IDigraph An edge-weighted, directed graph.
     * There is an edge in the result for each pair of vertices
     * if a path that connects those vertices exists.
     * The weight on the edge is the length of the shortest path
     * between the two vertices it connects.
     */
    public static function floydsAlgorithm(IDigraph $g)
    {
        $n = $g->getNumberOfVertices();
        $distance = new DenseMatrix($n, $n);
        for ($v = 0; $v < $n; ++$v)
            for ($w = 0; $w < $n; ++$w)
                $distance[array($v,$w)] = Limits::MAXINT;

        foreach ($g->getEdges() as $edge)
        {
            $wt = $edge->getWeight();
            $distance[array($edge->getV0()->getNumber(),
                $edge->getV1()->getNumber())] = unbox($wt);
        }

        for ($i = 0; $i < $n; ++$i)
            for ($v = 0; $v < $n; ++$v)
                for ($w = 0; $w < $n; ++$w)
                    if ($distance[array($v,$i)] != Limits::MAXINT
                    && $distance[array($i,$w)] != Limits::MAXINT)
                    {
                        $d = $distance[array($v,$i)]
                            + $distance[array($i,$w)];
                        if ($distance[array($v,$w)] > $d)
                            $distance[array($v,$w)] = $d;
                    }

        $result = new DigraphAsMatrix($n);
        for ($v = 0; $v < $n; ++$v)
            $result->addVertex($v);
        for ($v = 0; $v < $n; ++$v)
            for ($w = 0; $w < $n; ++$w)
                if ($distance[array($v,$w)] != limits::MAXINT)
                    $result->addEdge($v, $w,
                        box($distance[array($v,$w)]));
        return $result;
    }
//}>d

//{
    /**
     * Prim's algorithm to find a minimum-cost spanning tree
     * for the given edge-weighted, undirected graph.
     *
     * @param object IGraph $g An edge-weighted, undirected graph.
     * It is assumed that the edge weights are <code>Int</code>s
     * @param integer $s
     * A vertex from which to begin constructing the spanning tree.
     * @return object IGraph An unweighted, undirected graph that represents
     * the minimum-cost spanning tree.
     */
    public static function primsAlgorithm(IGraph $g, $s)
    {
        $n = $g->getNumberOfVertices();
        $table = new BasicArray($n);
        for ($v = 0; $v < $n; ++$v)
            $table[$v] = new Algorithms_Entry();
        $table[$s]->distance = 0;
        $queue = new BinaryHeap($g->getNumberOfEdges());
        $queue->enqueue(
            new Association(box(0), $g->getVertex($s)));
        while (!$queue->isEmpty())
        {
            $assoc = $queue->dequeueMin();
            $v0 = $assoc->getValue();
            $n0 = $v0->getNumber();
            if (!$table[$n0]->known)
            {
                $table[$n0]->known = true;
                foreach ($v0->getEmanatingEdges() as $edge)
                {
                    $v1 = $edge->getMate($v0);
                    $n1 = $v1->getNumber();
                    $wt = $edge->getWeight();
                    $d = unbox($wt);
                    if (!$table[$n1]->known &&
                        $table[$n1]->distance > $d)
                    {
                        $table[$n1]->distance = $d;
                        $table[$n1]->predecessor = $n0;
                        $queue->enqueue(
                            new Association(box($d), $v1));
                    }
                }
            }
        }
        $result = new GraphAsLists($n);
        for ($v = 0; $v < $n; ++$v)
            $result->addVertex($v);
        for ($v = 0; $v < $n; ++$v)
            if ($v != $s)
                $result->addEdge($v, $table[$v]->predecessor);
        return $result;
    }
//}>e

//{
    /**
     * Kruskal's algorithm to find a minimum-cost spanning tree
     * for the given edge-weighted, undirected graph.
     * Uses a partition and a priority queue.
     *
     * @param object IGraph $g An edge-weighted, undirected graph.
     * It is assumed that the edge weights are <code>Int</code>s
     * @return object IGraph An unweighted, undirected graph that represents
     * the minimum-cost spanning tree.
     */
    public static function kruskalsAlgorithm(IGraph $g)
    {
        $n = $g->getNumberOfVertices();

        $result = new GraphAsLists($n);
        for ($v = 0; $v < $n; ++$v)
            $result->addVertex($v);

        $queue = new BinaryHeap($g->getNumberOfEdges());
        foreach ($g->getEdges() as $edge)
        {
            $weight = $edge->getWeight();
            $queue->enqueue(new Association($weight, $edge));
        }

        $partition = new PartitionAsForest($n);
        while (!$queue->isEmpty() && $partition->getCount() > 1)
        {
            $assoc = $queue->dequeueMin();
            $edge = $assoc->getValue();
            $n0 = $edge->getV0()->getNumber();
            $n1 = $edge->getV1()->getNumber();
            $s = $partition->findItem($n0);
            $t = $partition->findItem($n1);
            if ($s !== $t)
            {
                $partition->join($s, $t);
                $result->addEdge($n0, $n1);
            }
        }
        return $result;
    }
//}>f

//{
    /**
     * Computes the critical path in an event-node graph.
     *
     * @param object IDigraph $g An edge-weighted, directed acylic graph.
     * It is assumed that the edge weights are <code>Int</code>s
     * @return object IDigraph A vertex-weighted, directed graph.
     * The events (vertices) on the critical path have zero weight.
     * The one edge that emantes from a vertex connects that vertex
     * to its predecessor on the critical path.
     */
    public static function criticalPathAnalysis(IDigraph $g)
    {
        $n = $g->getNumberOfVertices();

        $earliestTime = new BasicArray($n);
        $earliestTime[0] = 0;
        $g->topologicalOrderTraversal(
            new EarliestTimeVisitor($earliestTime));

        $latestTime = new BasicArray($n);
        $latestTime[$n - 1] = $earliestTime[$n - 1];
        $g->depthFirstTraversal(new PostOrder(
            new LatestTimeVisitor($latestTime)), 0);
        
        $slackGraph = new DigraphAsLists($n);
        for ($v = 0; $v < $n; ++$v)
            $slackGraph->addVertex($v);
        foreach ($g->getEdges() as $edge)
        {
            $n0 = $edge->getV0()->getNumber();
            $n1 = $edge->getV1()->getNumber();
            $wt = $edge->getWeight();
            $slack = $latestTime[$n1] - $earliestTime[$n0] -
                unbox($wt);
            $slackGraph->addEdge($n0, $n1, box($slack));
        }
        return Algorithms::dijkstrasAlgorithm($slackGraph, 0);
    }
//}>h

//{
    /**
     * A reverse-polish calculator.
     * Reads RPN expression from the input stream
     * and writes the computed results on the output stream.
     * Uses a stack.
     * Recognizes single-digit numbers, * +, * and =.
     *
     * @param resource $in The input stream.
     * @param resource $out The output stream.
     */
    public function calculator($in, $out)
    {
        $stack = new StackAsLinkedList();
        while (($c = fgetc($in)) !== false)
        {
            if (ord($c) >= ord('0') && ord($c) <= ord('9'))
            {
                $stack->push(box(ord($c) - ord('0')));
            }
            elseif ($c == '+')
            {
                $arg2 = $stack->pop();
                $arg1 = $stack->pop();
                $stack->push(box(
                    $arg1->getValue() + $arg2->getValue()));
            }
            elseif ($c == '*')
            {
                $arg2 = $stack->pop();
                $arg1 = $stack->pop();
                $stack->push(box(
                    $arg1->getValue() * $arg2->getValue()));
            }
            elseif ($c == '=')
            {
                $arg = $stack->pop();
                fprintf($out, "%s\n", str($arg));
            }
        }
    }
//}>j

//{
    /**
     * Counts the number of distinct words in the input stream and then
     * prints a table of the words and the number of occurrences
     * on the output stream.
     * Uses a hash table.
     *
     * @param resource $in The input stream.
     * @param resource $out The output stream.
     */
    public static function wordCounter($in, $out)
    {
        $table = new ChainedHashTable(1031);

        while (($line = fgets($in)) != false)
        {
            $words = preg_split(
                '/[ \t\n]+/', $line, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($words as $word)
            {
                $assoc = $table->find(
                    new Association(box($word)));
                if ($assoc === NULL)
                {
                    $table->insert(
                        new Association(box($word), box(1)));
                }
                else
                {
                    $count = unbox($assoc->getValue());
                    $assoc->setValue(box($count + 1));
                }
            }
        }
        fprintf($out, "%s\n", str($table));
    }
//}>k

//{
    /**
     * Reads a dictionary and then translates the words in an input text
     * word-by-word, printing the result on the output stream.
     * The dictionary consists of pairs of words.
     * The first element of each pair is a word in source language.
     * The second element of each pair is the word in the target language.
     * Uses a search tree.
     *
     * @param resource $dictionary An input stream
     * from which the pairs of words are read.
     * @param resource $in The input stream to be translated.
     * @param resource $out The output stream on which to print the translation.
     */
    public static function translate($dictionary, $in, $out)
    {
        $searchTree = new AVLTree();
        while (($line = fgets($dictionary)) != false)
        {
            $line = preg_replace('/\n$/', '', $line);
            list($key, $value) =
                preg_split('/[ \t]+/', $line, 2);
            $searchTree->insert(
                new Association(box($key), box($value)));
        }
        while (($line = fgets($in)) != false)
        {
            $words = preg_split(
                '/[ \t\n]+/', $line, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($words as $word)
            {
                $obj = $searchTree->find(
                    new Association(box($word)));
                if ($obj === NULL)
                {
                    fprintf($out, "%s ", $word);
                }
                else
                {
                    fprintf($out, "%s ", str($obj->getValue()));
                }
            }
        }
    }
//}>l

}
?>
