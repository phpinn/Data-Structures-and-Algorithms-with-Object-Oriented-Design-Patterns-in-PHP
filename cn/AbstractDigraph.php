<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractDigraph.php,v 1.2 2005/12/09 01:11:02 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractGraph.php';
require_once 'Opus11/PreOrder.php';
require_once 'Opus11/PrintingVisitor.php';
require_once 'Opus11/Exceptions.php';
require_once 'Opus11/Box.php';

//{
/**
 * Abstract base class from which all digraph classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractDigraph
    extends AbstractGraph
    implements IDigraph
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs an AbstractDigraph with the specified size.
     *
     * @param integer $size The maximum number of vertices.
     */
    public function __construct($size)
    {
        parent::__construct();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->vertex = NULL;
    }

    /**
     * Digraph test method.
     *
     * @param object IDigraph $g The digraph to test.
     */
    public static function test(IDigraph $g)
    {
        printf("Digraph test program.\n");
        AbstractGraph::Test($g);

        printf("TopologicalOrderTraversal\n");
        $g->topologicalOrderTraversal(new PrintingVisitor(STDOUT));

        printf("isCyclic returns %s\n",
            str($g->isCyclic()));
        printf("isStronglyConnected returns %s\n",
            str($g->isStronglyConnected()));
    }

    /**
     * Weighted graph test method.
     *
     * @param object IDigraph $g The weighted graph to test.
     */
    public static function testWeighted(IDigraph $g)
    {
        printf("Weighted digraph test program.\n");
        AbstractGraph::testWeighted($g);
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractDigraph main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractDigraph::main(array_slice($argv, 1)));
}
?>
