<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Application11.php,v 1.2 2005/12/09 01:11:05 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Algorithms.php';

/**
 * Provides application program number 11.
 *
 * @package Opus11
 */
class Application11
{
    /**
     * Weighted graph test program.
     *
     * @param object IGraph $g The weighted graph to test.
     */
    public static function weightedGraphTest(IGraph $g)
    {
        printf("Weighted graph test program.\n");
        $g->addVertex(0, box(123));
        $g->addVertex(1, box(234));
        $g->addVertex(2, box(345));
        $g->addEdge(0, 1, box(3));
        $g->addEdge(0, 2, box(1));
        $g->addEdge(1, 2, box(4));
        printf("%s\n", str($g));
        printf("Prim's Algorithm\n");
        $g2 = Algorithms::primsAlgorithm($g, 0);
        printf("%s\n", str($g2));
        printf("Kruskal's Algorithm\n");
        $g2 = Algorithms::kruskalsAlgorithm($g);
        printf("%s\n", str($g2));
    }

    /**
     * Weighted digraph test program.
     *
     * @param object IDigraph $g The weighted digraph to test.
     */
    public static function weightedDigraphTest(IDigraph $g)
    {
        printf("Weighted digraph test program.\n");
        Application11::weightedGraphTest($g);
        printf("Dijkstra's Algorithm\n");
        $g2 = Algorithms::dijkstrasAlgorithm($g, 0);
        printf("%s\n", str($g2));
        printf("Floyd's Algorithm\n");
        $g2 = Algorithms::floydsAlgorithm($g);
        printf("%s\n", str($g2));
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Application program number 11.\n");
        $status = 0;

        $g = new GraphAsMatrix(32);
        Application11::weightedGraphTest($g);

        $g = new GraphAsLists(32);
        Application11::weightedGraphTest($g);

        $g = new DigraphAsMatrix(32);
        Application11::weightedDigraphTest($g);

        $g = new DigraphAsLists(32);
        Application11::weightedDigraphTest($g);

        printf("Critical path analysis.\n");
        $g = new DigraphAsMatrix(10);
        for ($v = 0; $v < 10; ++$v)
        {
            $g->addVertex($v);
        }
        $g->addEdge(0, 1, box(3));
        $g->addEdge(1, 2, box(1));
        $g->addEdge(1, 3, box(4));
        $g->addEdge(2, 4, box(0));
        $g->addEdge(3, 4, box(0));
        $g->addEdge(4, 5, box(1));
        $g->addEdge(5, 6, box(9));
        $g->addEdge(5, 7, box(5));
        $g->addEdge(6, 8, box(0));
        $g->addEdge(7, 8, box(0));
        $g->addEdge(8, 9, box(2));
        printf("%s\n", str($g));
        $g2 = Algorithms::criticalPathAnalysis($g);
        printf("%s\n", str($g2));

        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Application11::main(array_slice($argv, 1)));
}
?>
