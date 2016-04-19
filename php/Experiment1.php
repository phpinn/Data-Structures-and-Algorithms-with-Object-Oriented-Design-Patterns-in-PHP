<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Experiment1.php,v 1.4 2005/12/09 01:11:11 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Example.php';
require_once 'Opus11/Timer.php';

/**
 * Program that measures the running times of both
 * a recursive and a non-recursive method that computes
 * the Fibonacci numbers.
 *
 * @package Opus11
 */
class Experiment1
{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        $status = 0;
        printf("3\n");
        printf("n\n");
        printf("fib1 s\n");
        printf("fib2 s\n");
        for ($i = 0; $i < 48; ++$i)
        {
            $timer = new Timer();
            $timer->start();
            $result = fibonacci($i);
            $timer->stop();
            $time1 = $timer->getElapsedTime();

            $timer->start();
            $result = fibonacci2($i);
            $timer->stop();
            $time2 = $timer->getElapsedTime();

            printf("%d\t%f\t%f\n", $i, $time1, $time2);
        }
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Experiment1::main(array_slice($argv, 1)));
}
?>
