<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: DigraphAsLists.php,v 1.2 2005/12/09 01:11:11 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/GraphAsLists.php';
require_once 'Opus11/IDigraph.php';
require_once 'Opus11/AbstractDigraph.php';

//{
/**
 * A directed graph implemented using adjacency lists.
 *
 * @package Opus11
 */
class DigraphAsLists
    extends GraphAsLists
    implements IDigraph
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a DigraphAsLists with the specified size.
     *
     * @param size The maximum number of vertices.
     */
    public function __construct($size = 0)
    {
        parent::__construct($size);
    }
//}>a

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
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
        ++$this->numberOfEdges;
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
