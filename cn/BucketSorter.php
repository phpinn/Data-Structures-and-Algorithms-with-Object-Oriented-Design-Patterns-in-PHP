<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: BucketSorter.php,v 1.2 2005/12/09 01:11:08 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSorter.php';

//{
/**
 * Implements bucket sort.
 *
 * @package Opus11
 */
class BucketSorter
    extends AbstractSorter
{
    /**
     * The number of counters (buckets).
     */
    protected $m = 0;
    /**
     * The counters (buckets).
     */
    protected $count = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructor.
     *
     * @param integer $m The number of buckets.
     */
    public function __construct($m)
    {
        parent::__construct();
        $this->m = $m;
        $this->count = new BasicArray($m);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->count = NULL;
        parent::__destruct();
    }
//}>a

//{
    /**
     * Sorts the array of comparable objects.
     */
    protected function doSort()
    {
        for ($i = 0; $i < $m; ++$i)
            $this->count[$i] = 0;
        for ($j = 0; $j < $this->n; ++$j)
        {
            $value = $this->array[$j];
            $this->count[$value] = $this->count[$value] + 1;
        }
        for ($i = 0, $j = 0; $i < $this->m; ++$i)
        {
            while ($this->count[$i] > 0)
            {
                $this->array[$j++] = $i;
                $this->count[$i] = $this->count[$i] - 1;
            }
        }
    }
//}>b

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("BucketSorter main program.\n");
        $status = 0;
        $sorter = new BucketSorter(1000);
        AbstractSorter::test($sorter, 10000, 123, 100);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(BucketSorter::main(array_slice($argv, 1)));
}
?>
