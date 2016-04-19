<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: BinaryInsertionSorter.php,v 1.2 2005/12/09 01:11:07 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSorter.php';

//{
/**
 * Implements binary insertion sort.
 *
 * @package Opus11
 */
class BinaryInsertionSorter
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
     * Sorts the array of comparable objects.
     */
    protected function doSort()
    {
        for ($i = 1; $i < $this->n; ++$i)
        {
            $tmp = $this->array[$i];
            $left = 0;
            $right = $i;
            while ($left < $right)
            {
                $middle = intval(($left + $right) / 2);
                if (ge($tmp, $this->array[$middle]))
                    $left = $middle + 1;
                else
                    $right = $middle;
            }
            for ($j = $i; $j > $left; --$j)
                $this->swap($j - 1, $j);
        }
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
        printf("BinaryInsertionSorter main program.\n");
        $status = 0;
        $sorter = new BinaryInsertionSorter();
        AbstractSorter::test($sorter, 100, 123);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(BinaryInsertionSorter::main(array_slice($argv, 1)));
}
?>
