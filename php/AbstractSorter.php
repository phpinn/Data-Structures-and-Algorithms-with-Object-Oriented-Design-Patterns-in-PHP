<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractSorter.php,v 1.3 2005/12/09 01:11:05 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractObject.php';
require_once 'Opus11/ISorter.php';
require_once 'Opus11/IComparable.php';
require_once 'Opus11/RandomNumberGenerator.php';
require_once 'Opus11/Timer.php';
require_once 'Opus11/Limits.php';

//{
/**
 * Abstract base class from which all sorter classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractSorter
    extends AbstractObject
    implements ISorter
{
    /**
     * @var object BasicArray The array to be sorted.
     */
    protected $array = NULL;
    /**
     * @var integer The length of the array to be sorted.
     */
    protected $n = 0;

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

    /**
     * Sorts the array to which the array field refers.
     */
    protected abstract function doSort();

    /**
     * Sorts the specified array of comparable objects
     * from "smallest" to "largest".
     * Calls the abstract <code>sort</code> method to do the actual sort.
     *
     * @param object BasicArray $array The array of objects to be sorted.
     */
    public function sort(BasicArray $array)
    {
        $this->n = $array->getLength();
        $this->array = $array;
        if ($this->n > 0)
            $this->doSort();
        $this->array = NULL;
    }

    /**
     * Swaps the specified elements the array
     * to which the array field refers.
     *
     * @param integer $i An index.
     * @param integer $j An index.
     */
    protected function swap($i, $j)
    {
        $tmp = $this->array[$i];
        $this->array[$i] = $this->array[$j];
        $this->array[$j] = $tmp;
    }
//}>a

    /**
     * Sorter test method.
     *
     * @param object ISorter $sorter The sorter to test.
     * @param integer $n The length of array to test.
     * @param integer $seed A seed for the random number generator.
     * @param integer $m If given, data values are restricted to [0,m-1].
     * (Optional).
     */
    public static function test(ISorter $sorter, $n, $seed, $m = 0)
    {
        //printf("AbstractSorter test program.\n");
        RandomNumberGenerator::setSeed($seed);
        $data = new BasicArray($n);
        for ($i = 0; $i < $n; ++$i)
        {
            $datum = intval(RandomNumberGenerator::next() * Limits::MAXINT);
            if ($m != 0)
            {
                $datum = $datum % $m;
            }
            $data[$i] = $datum;
        }
        $timer = new Timer();
        $timer->start();
        $sorter->sort($data);
        $timer->stop();
        $datum = sprintf("%s %d %d %f", $sorter->getClass()->getName(),
            $n, $seed, $timer->getElapsedTime());
        fprintf(STDOUT, "%s\n", $datum);
        fprintf(STDERR, "%s\n", $datum);
        for ($i = 1; $i < $n; ++$i)
        {
            if ($data[$i] < $data[$i - 1])
            {
                printf("FAILED\n");
                break;
            }
        }
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractSorter main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractSorter::main(array_slice($argv, 1)));
}
?>
