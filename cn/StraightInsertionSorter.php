<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: StraightInsertionSorter.php,v 1.2 2005/12/09 01:11:17 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSorter.php';

//{
/**
 * Implements straight insertion sort.
 *
 * @package Opus11
 */
class StraightInsertionSorter
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
            for ($j = $i; $j > 0 &&
                gt($this->array[$j - 1], $this->array[$j]); --$j)
            {
                $this->swap($j, $j - 1);
            }
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
        printf("StraightInsertionSorter main program.\n");
        $status = 0;
        $sorter = new StraightInsertionSorter();
        AbstractSorter::test($sorter, 100, 123);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(StraightInsertionSorter::main(array_slice($argv, 1)));
}
?>
