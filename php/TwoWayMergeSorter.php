<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: TwoWayMergeSorter.php,v 1.2 2005/12/09 01:11:18 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSorter.php';

//{
/**
 * Implements two-way merge sort.
 *
 * @package Opus11
 */
class TwoWayMergeSorter
    extends AbstractSorter
{
    /**
     * Temporary array used during merge.
     */
    protected $tempArray = NULL;

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
     * Merges two sorted subsequences of the array into one.
     * @param integer $left The first position of the left subsequence.
     * @param integer $middle The first position of the right subsequence.
     * The last position in the left subsequences is middle-1.
     * @param integer $right The last position of the right subsequence.
     */
    protected function merge($left, $middle, $right)
    {
        $i = $left;
        $j = $left;
        $k = $middle + 1;
        while ($j <= $middle && $k <= $right)
        {
            if (lt($this->array[$j], $this->array[$k]))
                $this->tempArray[$i++] = $this->array[$j++];
            else
                $this->tempArray[$i++] = $this->array[$k++];
        }
        while ($j <= $middle)
            $this->tempArray[$i++] = $this->array[$j++];
        for ($i = $left; $i < $k; ++$i)
            $this->array[$i] = $this->tempArray[$i];
    }
//}>b

//{
    /**
     * Sorts the array of comparable objects.
     */
    protected function doSort()
    {
        $this->tempArray = new BasicArray($this->n);
        $this->sortSlice(0, $this->n - 1);
        $this->tempArray = NULL;
    }

    /**
     * Sorts the specified range of positions in the array.
     * @param integer $left
     * The position of the left end of the range to be sorted.
     * @param integer $right
     * The position of the right end of the range to be sorted.
     */
    protected function sortSlice($left, $right)
    {
        if ($left < $right)
        {
            $middle = intval(($left + $right) / 2);
            $this->sortSlice($left, $middle);
            $this->sortSlice($middle + 1, $right);
            $this->merge($left, $middle, $right);
        }
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
        printf("TwoWayMergeSorter main program.\n");
        $status = 0;
        $sorter = new TwoWayMergeSorter();
        AbstractSorter::test($sorter, 1000, 123);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(TwoWayMergeSorter::main(array_slice($argv, 1)));
}
?>
