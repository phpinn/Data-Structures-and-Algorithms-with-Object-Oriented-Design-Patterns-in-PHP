<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: StraightSelectionSorter.php,v 1.2 2005/12/09 01:11:18 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSorter.php';

//{
/**
 * Implements straight selection sort.
 *
 * @package Opus11
 */
class StraightSelectionSorter
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
        for ($i = $this->n; $i > 1; --$i)
        {
            $max = 0;
            for ($j = 1; $j < $i; ++$j)
                if (gt($this->array[$j], $this->array[$max]))
                    $max = $j;
            $this->swap($i - 1, $max);
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
        printf("StraightSelectionSorter main program.\n");
        $status = 0;
        $sorter = new StraightSelectionSorter();
        AbstractSorter::test($sorter, 100, 123);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(StraightSelectionSorter::main(array_slice($argv, 1)));
}
?>
