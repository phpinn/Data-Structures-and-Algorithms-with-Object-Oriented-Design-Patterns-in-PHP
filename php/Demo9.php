<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Demo9.php,v 1.9 2005/12/09 01:11:10 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/StraightInsertionSorter.php';
require_once 'Opus11/BinaryInsertionSorter.php';
require_once 'Opus11/BubbleSorter.php';
require_once 'Opus11/StraightSelectionSorter.php';
require_once 'Opus11/HeapSorter.php';
require_once 'Opus11/MedianOfThreeQuickSorter.php';
require_once 'Opus11/TwoWayMergeSorter.php';
require_once 'Opus11/BucketSorter.php';
require_once 'Opus11/RadixSorter.php';

/**
 * Provides demonstration program number 9.
 *
 * @package Opus11
 */
class Demo9
{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on succes; non-zero on failure.
     */
    public static function main($args, $arg0)
    {
        //printf("Demonstration program number 9.\n");
        $status = 0;
        if (count($args) != 3)
        {
            printf("usage: %s size seed mask\n", $arg0);
            $status = 1;
        }
        else
        {
            $n = intval($args[0]);
            $seed = intval($args[1]);
            $mask = intval($args[2]);
            if ($mask & 4 != 0)
            {
                AbstractSorter::test(
                    new StraightInsertionSorter(), $n, $seed, $mask);
                AbstractSorter::test(
                    new BinaryInsertionSorter(), $n, $seed, $mask);
                AbstractSorter::test(
                    new BubbleSorter(), $n, $seed, $mask);
                AbstractSorter::test(
                    new StraightSelectionSorter(), $n, $seed, $mask);
            }
            if ($mask & 2 != 0)
            {
                AbstractSorter::test(
                    new HeapSorter(), $n, $seed, $mask);
                AbstractSorter::test(
                    new MedianOfThreeQuickSorter(), $n, $seed, $mask);
                AbstractSorter::test(
                    new TwoWayMergeSorter(), $n, $seed, $mask);
            }
            if ($mask & 1 != 0)
            {
                AbstractSorter::test(
                    new BucketSorter(1024), $n, $seed, $mask, 1024);
                AbstractSorter::test(
                    new RadixSorter(), $n, $seed, $mask);
            }
        }
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Demo9::main(array_slice($argv, 1), $argv[0]));
}
?>
