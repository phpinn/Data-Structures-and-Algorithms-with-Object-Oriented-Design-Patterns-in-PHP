<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: MedianOfThreeQuickSorter.php,v 1.2 2005/12/09 01:11:13 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractQuickSorter.php';

//{
/**
 * Implements quicksort using median-of-three pivot selection.
 *
 * @package Opus11
 */
class MedianOfThreeQuickSorter
    extends AbstractQuickSorter
{
//}@head

//{
//!    // ...
//!}
//}@tail

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

//{
    /**
     * Selects an element in the specified range of the array
     * to serve as the pivot.
     *
     * @param integer $left The leftmost element of the range to consider.
     * @param integer $right The rightmost element of the range to consider.
     * @return The position of the pivot.
     */
    protected function selectPivot($left, $right)
    {
        $middle = intval(($left + $right) / 2);
        if (gt($this->array[$left], $this->array[$middle]))
            $this->swap($left, $middle);
        if (gt($this->array[$left], $this->array[$right]))
            $this->swap($left, $right);
        if (gt($this->array[$middle], $this->array[$right]))
            $this->swap($middle, $right);
        return $middle;
    }
//}>a

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("MedianOfThreeQuickSorter main program.\n");
        $status = 0;
        $sorter = new MedianOfThreeQuickSorter();
        AbstractSorter::test($sorter, 1000, 123);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(MedianOfThreeQuickSorter::main(array_slice($argv, 1)));
}
?>
