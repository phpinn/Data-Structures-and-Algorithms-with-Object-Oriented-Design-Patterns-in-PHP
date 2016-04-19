<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Demo6.php,v 1.7 2005/12/09 01:11:10 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/BinaryHeap.php';
require_once 'Opus11/LeftistHeap.php';
require_once 'Opus11/BinomialQueue.php';
require_once 'Opus11/Deap.php';

/**
 * Provides demonstration program number 6.
 * 
 * @package Opus11
 */
class Demo6
{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on succes; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Demonstration program number 6.\n");
        $status = 0;
        BinaryHeap::main($args);
        LeftistHeap::main($args);
        BinomialQueue::main($args);
        Deap::main($args);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Demo6::main(array_slice($argv, 1)));
}
?>
