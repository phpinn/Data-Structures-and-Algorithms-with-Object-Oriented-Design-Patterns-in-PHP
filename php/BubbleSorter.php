<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: BubbleSorter.php,v 1.2 2005/12/09 01:11:08 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSorter.php';

//{
/**
 * Implements bubble sort.
 *
 * @package Opus11
 */
class BubbleSorter
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
            for ($j = 0; $j < $i - 1; ++$j)
                if (gt($this->array[$j], $this->array[$j + 1]))
                    $this->swap($j, $j + 1);
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
        printf("BubbleSorter main program.\n");
        $status = 0;
        $sorter = new BubbleSorter();
        AbstractSorter::test($sorter, 100, 123);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(BubbleSorter::main(array_slice($argv, 1)));
}
?>
