<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractDeque.php,v 1.11 2005/12/09 01:11:02 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractQueue.php';
require_once 'Opus11/IDeque.php';
require_once 'Opus11/Box.php';

//{
/**
 * Abstract base class from which all deque classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractDeque
    extends AbstractQueue
    implements IDeque
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
     * Enqueues the given object at the head of this deque.
     *
     * @param object IObject $obj The object to enqueue.
     */
    public function enqueue(IObject $obj)
    {
        $this->enqueueHead($obj);
    }

    /**
     * Dequeues the given object from the tail of this deque.
     *
     * @return object IObject The object at the tail of this deque.
     */
    public function dequeue()
    {
        return $this->dequeueTail();
    }

    /**
     * Deque test method.
     *
     * @param object IDeque $deque The deque to test.
     */
    public static function test(IDeque $deque)
    {
        printf("AbstractDeque test program.\n");

        for ($i = 0; $i <= 5; ++$i)
        {
            if (!$deque->isFull())
                $deque->enqueueHead(box($i));
            if (!$deque->isFull())
                $deque->enqueueTail(box($i));
        }
        printf("%s\n", str($deque));
        printf("getHead = %s\n", str($deque->getHead()));
        printf("getTail = %s\n", str($deque->getTail()));

        printf("Using reduce\n");
        $deque->reduce(create_function(
            '$sum,$obj', 'printf("%s\n", str($obj));'), '');

        printf("Using foreach\n");
        foreach ($deque as $obj)
        {
            printf("%s\n", str($obj));
        }

        printf("Dequeueing\n");
        while (!$deque->isEmpty())
        {
            printf("%s\n", str($deque->dequeueHead()));
            if ($deque->isEmpty())
                break;
            printf("%s\n", str($deque->dequeueTail()));
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
        printf("AbstractDeque main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractDeque::main(array_slice($argv, 1)));
}
?>
