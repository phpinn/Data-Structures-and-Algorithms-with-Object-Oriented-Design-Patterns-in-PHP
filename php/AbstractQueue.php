<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractQueue.php,v 1.8 2005/12/09 01:11:04 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractContainer.php';
require_once 'Opus11/IQueue.php';
require_once 'Opus11/Box.php';

//{
/**
 * Abstract base class from which all queue classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractQueue
    extends AbstractContainer
    implements IQueue
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
     * Queue test method.
     *
     * @param object IQueue $queue The queue to test.
     */
    public static function test(IQueue $queue)
    {
        printf("AbstractQueue test program.\n");
        for ($i = 0; $i < 5; ++$i)
        {
            if ($queue->isFull())
                break;
            $queue->enqueue(box($i));
        }
        printf("%s\n", str($queue));

        printf("Using reduce\n");
        $queue->reduce(create_function(
            '$sum,$obj', 'printf("%s\n", str($obj));'), '');

        printf("Using foreach\n");
        foreach ($queue as $obj)
        {
            printf("%s\n", str($obj));
        }
        printf("getHead\n");
        printf("%s\n", str($queue->getHead()));

        printf("Dequeueing\n");
        while (!$queue->isEmpty())
        {
            printf("%s\n", str($queue->dequeue()));
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
        printf("AbstractQueue main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractQueue::main(array_slice($argv, 1)));
}
?>
