<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractQuickSorter.php,v 1.3 2005/12/09 01:11:04 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSorter.php';
require_once 'Opus11/StraightInsertionSorter.php';

//{
/**
 * Abstract base class from which all quick sorter classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractQuickSorter
    extends AbstractSorter
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
     * Selects an element from the slice of the array between
     * the specified left and right positions
     * (inclusive) to serve as the pivot.
     * @param integer $left
     * The position of the leftmost array element to consider.
     * @param integer $right
     * The position of the rightmost array element to consider.
     * @return The position of the pivot.
     */
    protected abstract function selectPivot($left, $right);
//}>a

//{
    /**
     * The length of the smallest array slice to quicksort.
     */
    const CUTOFF = 2; // minimum cut-off

    /**
     * Recursively quicksorts the slice of the array between
     * the specified left and right positions.
     *
     * @param integer $left The position of the leftmost element to be sorted.
     * @param integer $right The position of the rightmost element to be sorted.
     */
    protected function sortSlice($left, $right)
    {
        if ($right - $left + 1 > self::CUTOFF)
        {
            $p = $this->selectPivot($left, $right);
            $this->swap($p, $right);
            $pivot = $this->array[$right];
            $i = $left;
            $j = $right - 1;
            for (;;)
            {
                while ($i < $j && lt($this->array[$i], $pivot))
                    ++$i;
                while ($i < $j && gt($this->array[$j], $pivot))
                    --$j;
                if ($i >= $j) break;
                $this->swap($i++, $j--);
            }
            if (gt($this->array[$i], $pivot))
                $this->swap($i, $right);
            if ($left < $i)
                $this->sortSlice($left, $i - 1);
            if ($right > $i)
                $this->sortSlice($i + 1, $right);
        }
    }
//}>b

//{
    /**
     * Sorts the array to which the array field refers.
     * Calls the recursive quicksort method to do the actual sort.
     * Since the recursive quicksort method stops short of finishing the sort,
     * this method uses a StraightInsertionSorter to finish the job.
     */
    protected function doSort()
    {
        $this->sortSlice(0, $this->n - 1);
        $sorter = new StraightInsertionSorter();
        $sorter->sort($this->array);
    }
//}>c

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractQuickSorter main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractQuickSorter::main(array_slice($argv, 1)));
}
?>
