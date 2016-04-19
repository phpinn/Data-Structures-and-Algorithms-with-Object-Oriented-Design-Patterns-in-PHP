<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractStack.php,v 1.9 2005/12/09 01:11:05 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractContainer.php';
require_once 'Opus11/IStack.php';
require_once 'Opus11/Box.php';

//{
/**
 * Abstract base class from which all stack classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractStack
    extends AbstractContainer
    implements IStack
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
     * Stack test method.
     *
     * @param object IStack $stack The stack to test.
     */
    public static function test(IStack $stack)
    {
        printf("AbstractStack test program.\n");

        for ($i = 0; $i < 6; ++$i)
        {
            if ($stack->isFull())
                break;
            $stack->push(box($i));
        }
        printf("%s\n", str($stack));

        printf("Using foreach\n");
        foreach ($stack as $obj)
        {
            printf("%s\n", str($obj));
        }

        printf("Using reduce\n");
        $stack->reduce(create_function(
            '$sum,$obj', 'printf("%s\n", str($obj));'), '');

        printf("Top is %s\n", str($stack->getTop()));

        printf("Popping\n");
        while (!$stack->isEmpty())
        {
            $obj = $stack->pop();
            printf("%s\n", str($obj));
        }

        $stack->push(box(2));
        $stack->push(box(4));
        $stack->push(box(6));
        printf("%s\n", str($stack));
        printf("Purging\n");
        $stack->purge();
        printf("%s\n", str($stack));
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractStack main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractStack::main(array_slice($argv, 1)));
}
?>
