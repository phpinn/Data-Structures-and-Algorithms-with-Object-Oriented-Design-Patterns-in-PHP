<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Experiment2.php,v 1.2 2005/12/09 01:11:11 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Demo9.php';

/**
 * Measures the running times of the various sorters.
 *
 * @package Opus11
 */
class Experiment2
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
        printf("4\n");
        printf("sort\n");
        printf("length\n");
        printf("seed\n");
        printf("time\n");
        foreach (array("1", "57", "12345", "7252795", "3127") as $seed)
        {
            foreach (array(
                "10", "250", "500", "750",
                "1000", "1250", "1500", "1750", "2000") as $length)
            {
                Demo9::main(array($length, $seed, "7"), $argv[0]);
            }
            foreach (array(
                "3000", "4000", "5000", "6000",
                "7000", "8000", "9000", "10000") as $length)
            {
                Demo9::main(array($length, $seed, "3"), $argv[0]);
            }
            foreach (array(
                "20000", "30000", "40000", "50000",
                "60000", "70000", "80000", "90000", "100000") as $length)
            {
                Demo9::main(array($length, $seed, "1"), $argv[0]);
            }
        }
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Experiment2::main(array_slice($argv, 1)));
}
?>
