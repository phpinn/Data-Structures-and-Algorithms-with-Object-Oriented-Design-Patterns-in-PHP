<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: RadixSorter.php,v 1.2 2005/12/09 01:11:16 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSorter.php';

//{
/**
 * Implements radix sort.
 *
 * @package Opus11
 */
class RadixSorter
    extends AbstractSorter
{
    /**
     * The logarithm to the base two of the radix.
     */
    const r = 8;
    /**
     * The radix.
     */
    const R = 256; // 1 << r
    /**
     * The number of passes.
     */
    const p = 4; // (32 + r - 1) / r
    /**
     * The array of counters (buckets).
     */
    protected $count = NULL;

//}>a

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $self->count = new BasicArray(self::R);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $self->count = NULL;
        parent::__destruct();
    }
//}>a

//{
    /**
     * Sorts the array of comparable objects.
     */
    protected function doSort()
    {
        $tempArray = new BasicArray($this->n);

        for ($i = 0; $i < self::p; ++$i)
        {
            for ($j = 0; $j < self::R; ++$j)
                $this->count[$j] = 0;
            for ($k = 0; $k < $this->n; ++$k)
            {
                $pos = ($this->array[$k] >> (self::r * $i)) & 
                    (self::R - 1);
                $this->count[$pos] += 1;
                $tempArray[$k] = $this->array[$k];
            }
            $pos = 0;
            for ($j = 0; $j < self::R; ++$j)
            {
                $tmp = $pos;
                $pos += $this->count[$j];
                $this->count[$j] = $tmp;
            }
            for ($k = 0; $k < $this->n; ++$k)
            {
                $pos = ($tempArray[$k] >> (self::r * $i)) &
                    (self::R - 1);
                $this->array[$this->count[$pos]] =
                    $tempArray [$k];
                $this->count[$pos] += 1;
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
        printf("RadixSorter main program.\n");
        $status = 0;
        $sorter = new RadixSorter();
        AbstractSorter::test($sorter, 10000, 123);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(RadixSorter::main(array_slice($argv, 1)));
}
?>
