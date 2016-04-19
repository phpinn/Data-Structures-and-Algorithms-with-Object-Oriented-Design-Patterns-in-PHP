<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: HeapSorter.php,v 1.2 2005/12/09 01:11:12 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSorter.php';

//{
/**
 * Implements heapsort.
 *
 * @package Opus11
 */
class HeapSorter
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
     * Percolates the object at position <empy>i</code>
     * in this heap down into the correct position.
     *
     * @param integer $i The position of the object to be percolated down.
     * @param integer $length The length of the heap.
     */
    protected function percolateDown($i, $length)
    {
        while (2 * $i <= $length)
        {
            $j = 2 * $i;
            if ($j < $length &&
                    gt($this->array[$j + 1], $this->array[$j]))
                $j = $j + 1;
            if (ge($this->array[$i], $this->array[$j]))
                break;
            $this->swap($i, $j);
            $i = $j;
        }
    }
//}>a

//{
    /**
     * Builds a heap from the unsorted array.
     */
    protected function buildHeap()
    {
        for ($i = intval($this->n / 2); $i > 0; --$i)
            $this->percolateDown($i, $this->n);
    }
//}>b

//{
    /**
     * Sorts the array of comparable objects.
     */
    protected function doSort()
    {
        $base = $this->array->getBaseIndex();
        $this->array->setBaseIndex(1);
        $this->buildHeap();
        for ($i = $this->n; $i >= 2; --$i)
        {
            $this->swap($i, 1);
            $this->percolateDown(1, $i - 1);
        }
        $this->array->setBaseIndex($base);
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
        printf("HeapSorter main program.\n");
        $status = 0;
        $sorter = new HeapSorter();
        AbstractSorter::test($sorter, 1000, 123);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(HeapSorter::main(array_slice($argv, 1)));
}
?>
