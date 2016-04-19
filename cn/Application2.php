<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Application2.php,v 1.5 2005/12/09 01:11:05 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Algorithms.php';
require_once 'Opus11/NaryTree.php';
require_once 'Opus11/Box.php';

/**
 * Provides application program number 2.
 *
 * @package Opus11
 */
class Application2
{
    /**
     * Builds an N-ary tree that contains character keys in the given range.
     *
     * @param integer lo The lower bound of the range.
     * @param integer hi The upper bound of the range.
     * @return An N-ary tree.
     */
    public static function buildTree($lo, $hi)
    {
        $mid = intval(($lo + $hi) / 2);
        $result = new NaryTree(2, box(chr($mid)));
        if ($lo < $mid)
        {
            $result->attachSubtree(0, self::buildTree($lo, $mid - 1));
        }
        if ($hi > $mid)
        {
            $result->attachSubtree(1, self::buildTree($mid + 1, $hi));
        }
        return $result;
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        $status = 0;
        printf("Application program number 2.\n");
        printf("Should be: dbfaceg.\n");
        $tree = self::buildTree(ord('a'), ord('g'));
        Algorithms::breadthFirstTraversal($tree);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Application2::main(array_slice($argv, 1)));
}
?>
