<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractDoubleEndedPriorityQueue.php,v 1.6 2005/12/09 01:11:02 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractPriorityQueue.php';
require_once 'Opus11/IDoubleEndedPriorityQueue.php';
require_once 'Opus11/Box.php';

//{
/**
 * Abstract base class from which all double-ended priority queue classes
 * are derived.
 *
 * @package Opus11
 */
abstract class AbstractDoubleEndedPriorityQueue
    extends AbstractPriorityQueue
    implements IDoubledEndedPriorityQueue
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
     * DoubledEndedPriorityQueue test method.
     *
     * @param object IPriorityQueue $pqueue The queue to test.
     */
    public static function test(IPriorityQueue $pqueue)
    {
        printf("AbstractDoubledEndedPriorityQueue test program.\n");
        AbstractPriorityQueue::test($pqueue);
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
        while (!$pqueue->isEmpty())
        {
            $obj = $pqueue->dequeueMax();
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
        printf("AbstractDoubleEndedPriorityQueue main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractDoubleEndedPriorityQueue::main(array_slice($argv, 1)));
}
?>
