<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractPriorityQueue.php,v 1.6 2005/12/09 01:11:04 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractContainer.php';
require_once 'Opus11/IPriorityQueue.php';
require_once 'Opus11/Box.php';

//{
/**
 * Abstract base class from which all priority queue classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractPriorityQueue
    extends AbstractContainer
    implements IPriorityQueue
{

//!    // ...
//!}
//}>a

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
     * PriorityQueue test method.
     *
     * @param object IPriorityQueue $pqueue The queue to test.
     */
    public static function test(IPriorityQueue $pqueue)
    {
        printf("AbstractPriorityQueue test program.\n");
        printf("%s\n", str($pqueue));
        $pqueue->enqueue(box(3));
        $pqueue->enqueue(box(1));
        $pqueue->enqueue(box(4));
        $pqueue->enqueue(box(1));
        $pqueue->enqueue(box(5));
        $pqueue->enqueue(box(9));
        $pqueue->enqueue(box(2));
        $pqueue->enqueue(box(6));
        $pqueue->enqueue(box(5));
        $pqueue->enqueue(box(4));
        printf("%s\n", str($pqueue));

        printf("Using reduce\n");
        $pqueue->reduce(create_function(
            '$sum,$obj', 'printf("%s\n", str($obj));'), '');

        printf("Using foreach\n");
        foreach ($pqueue as $obj)
        {
            printf("%s\n", str($obj));
        }

        printf("Dequeueing\n");
        while (!$pqueue->isEmpty())
        {
            $obj = $pqueue->dequeueMin();
            printf("%s\n", str($obj));
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
        printf("AbstractPriorityQueue main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractPriorityQueue::main(array_slice($argv, 1)));
}
?>
