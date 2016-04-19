<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Example.php,v 1.7 2005/12/09 01:11:11 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/RandomNumberGenerator.php';
require_once 'Opus11/Exceptions.php';
require_once 'Opus11/Limits.php';

/**
 * Provides various example methods.
 *
 * @package Opus11
 * @static
 */
class Example
{
//{
    /**
     * Returns the sum of the first n integers.
     *
     * @param integer $n The number of integers to sum.
     * @return integer The sum of the first n integers.
     */
    public static function sum($n)
    {
        $result = 0;
        for ($i = 1; $i <= $n; ++$i)
            $result += $i;
        return $result;
    }
//}>a

//{
    /**
     * Evaluates a polynomial in x.
     *
     * @param array $a The coefficients of the polynomial.
     * @param integer $n The degree of the polynomial.
     * @param mixed x The value of x.
     * @return mixed The value of the polynomial in x.
     */
    public static function horner($a, $n, $x)
    {
        $result = $a[$n];
        for ($i = $n - 1; $i >= 0; --$i)
            $result = $result * $x + $a[$i];
        return $result;
    }
//}>b

//{
    /**
     * Returns the factorial of n.
     *
     * @param integer $n The value of n.
     * @return integer The factorial of n.
     */
    public static function factorial($n)
    {
        if ($n == 0)
            return 1;
        else
            return $n * self::factorial($n - 1);
    }
//}>c

//{
    /**
     * Returns the largest integer in an array of n integers.
     *
     * @param array $a The array of integers.
     * @return integer The largest integer in the array.
     */
    public static function findMaximum($a)
    {
        $result = $a[0];
        for ($i = 1; $i < count($a); ++$i)
            if ($a[$i] > $result)
                $result = $a[$i];
        return $result;
    }
//}>d

//{
    /**
     * Approximates Euler's constant.
     *
     * @return float An approximation for Euler's constant.
     */
    public static function gamma()
    {
        $result = 0.0;
        for ($i = 1; $i <= 500000; ++$i)
            $result += 1.0/$i - log(($i + 1.0)/$i);
        return $result;
    }
//}>e

//{
    /**
     * Computes the sum the first n terms
     * of a geometric series in x.
     * Uses an order n squared algorithm.
     * @param mixed $x The value of x.
     * @param integer $n The number of terms to be added.
     * @return mixed The sum the first n terms
     * of a geometric series in x.
     */
    public static function geometricSeriesSum($x, $n)
    {
        $sum = 0;
        for ($i = 0; $i <= $n; ++$i)
        {
            $prod = 1;
            for ($j = 0; $j < $i; ++$j)
                $prod *= $x;
            $sum += $prod;
        }
        return $sum;
    }
//}>f

    /**
     * Computes the sum the first n terms
     * of a geometric series in x.
     * Uses Horner's rule.
     * @param mixed $x The value of x.
     * @param integer $n The number of terms to be added.
     * @return mixed The sum the first n terms
     * of a geometric series in x.
     */
    public static function geometricSeriesSum2($x, $n)
//{
    //!public static function geometricSeriesSum($x, $n)
    {
        $sum = 0;
        for ($i = 0; $i <= $n; ++$i)
            $sum = $sum * $x + 1;
        return $sum;
    }
//}>g

//{
    /**
     * Returns x raised to the power n.
     *
     * @param mixed $x The value of x.
     * @param integer $n The value of n.
     * @return mixed x raised to the power n.
     */
    public static function power($x, $n)
    {
        if ($n == 0)
            return 1;
        elseif ($n % 2 == 0) // n is even
            return self::power($x * $x, intval($n / 2));
        else // n is odd
            return $x * self::power($x * $x, intval($n / 2));
    }
//}>h

    /**
     * Computes the sum the first n terms
     * of a geometric series in x.
     * Uses the closed-form formula for the summation.
     *
     * @param mixed $x The value of x.
     * @param integer $n The number of terms to be added.
     * @return mixed The sum the first n terms
     * of a geometric series in x.
     */
    public static function geometricSeriesSum3($x, $n)
//{
    //!public static function geometricSeriesSum($x, $n)
    {
        return (self::power($x, $n + 1) - 1) / ($x - 1);
    }
//}>i

    /**
     * Evaluates a polynomial in x.
     *
     * @param array $a The coefficients of the polynomial.
     * @param integer $n The degree of the polynomial.
     * @param mixed $x The value of x.
     * @return mixed The value of the polynomial in x.
     */
    public static function horner2($a, $n, $x)
//{
    //!public static function horner($a, $n, $x)
    {
        $result = $a[$n];
        for ($i = $n - 1; $i >= 0; --$i)
            $result = $result * $x + $a[$i];
        return $result;
    }
//}>j

//{
    /**
     * Computes (in place) all the prefix sums
     * of an array of n integers.
     *
     * @param array $a The array of integers.
     * @param integer $n The length of the array of integers.
     */
    public static function prefixSums(&$a, $n)
    {
        for ($j = $n - 1; $j >= 0; --$j)
        {
            $sum = 0;
            for ($i = 0; $i <= $j; ++$i)
                $sum += $a[$i];
            $a[$j] = $sum;
        }
    }
//}>k

//{
    /**
     * Returns the n-th Fibonacci number.
     * Uses an iterative (non-recursive) algorithm.
     *
     * @param integer $n The value of n.
     * @return integer The n-th Fibonacci number.
     */
    public static function fibonacci($n)
    {
        $previous = -1;
        $result = 1;
        for ($i = 0; $i <= $n; ++$i)
        {
            $sum = $result + $previous;
            $previous = $result;
            $result = $sum;
        }
        return $result;
    }
//}>l

//{
    //[
    /**
     * Returns the nth Fibonacci number.
     * Uses a recursive algorithm.
     *
     * @param integer $n The value of n.
     * @return integer The nth Fibonacci number.
     */
    public static function fibonacci2($n)
    //]
    //!public static function fibonacci($n)
    {
        if ($n == 0 || $n == 1)
            return $n;
        else
    //[
            return self::fibonacci2($n - 1) +
                self::fibonacci2($n - 2);
    //]
            //!return self::fibonacci($n - 1) +
            //!    self::fibonacci($n - 2);
    }
//}>m

//{
    /**
     * Sorts (in place) an array of integers
     * which are known to fall in the interval [0,m-1].
     * Uses a bucket sort.
     *
     * @param array $a The array of integers to sort.
     * @param integer $n The length array of integers to sort.
     */
    public static function bucketSort(&$a, $m)
    {
        $buckets = array();

        for ($j = 0; $j < $m; ++$j)
            $buckets[$j] = 0;
        for ($i = 0; $i < count($a); ++$i)
            ++$buckets[$a[$i]];
        for ($i = 0, $j = 0; $j < $m; ++$j)
            for ($k = $buckets[$j]; $k > 0; --$k)
                $a[$i++] = $j;
    }
//}>n

//{
    /**
     * Returns the position of an integer in a specified contiguous
     * region in a sorted array of integers.
     * Uses a recursive, divide-and-conquer algorithm.
     *
     * @param array $a The array of integers.
     * @param mixed $target The target of the search.
     * @param integer $i The left end of the region to be searched.
     * @param integer $n The length of the region to be searched.
     * @return integer The position of the target in a sorted array of integers.
     * If the target is not in the array.
     */
    public static function binarySearch(
        $a, $target, $i, $n)
    {
        if ($n == 0)
            throw new ArgumentError();
        if ($n == 1)
        {
            if ($a[$i] == $target)
                return $i;
            throw new ArgumentError();
        }
        else
        {
            $j = $i + intval($n / 2);
            if ($a[$j] <= $target)
                return self::binarySearch(
                    $a, $target, $j, $n - intval($n/2));
            else
                return self::binarySearch (
                    $a, $target, $i, intval($n/2));
        }
    }
//}>o

    /**
     * Returns the n-th Fibonacci number.
     * Uses an efficient recursive algorithm.
     * @param integer $n The value of n.
     * @return integer The n-th Fibonacci number.
     */
    public static function fibonacci3($n)
//{
    //!public static function fibonacci($n)
    {
        if ($n == 0 || $n == 1)
            return $n;
        else
        {
            //!$a = self::fibonacci(intval(($n + 1) / 2));
            //!$b = self::fibonacci(intval(($n + 1) / 2) - 1);
    //[
            $a = self::fibonacci3(intval(($n + 1) / 2));
            $b = self::fibonacci3(intval(($n + 1) / 2) - 1);
    //]
            if ($n % 2 == 0)
                return $a * ($a + 2 * $b);
            else
                return $a * $a + $b * $b;
        }
    }
//}>p

    /**
    * Merges two sorted subsequences of an array
     * into a single sorted subsequence.
     *
     * @param array $a An array of comparable objects.
     * @param integer $pos The start of the left subsequence.
     * @param integer $m The number of elements in the left subsequence.
     * @param integer $n The number of elements in the right subsequence.
     */
    public static function merge(&$a, $pos, $m, $n)
    {
        $temp = array();
        $i = $pos;
        $left = $pos + $m;
        $j = $left;
        $right = $left + $n;
        $k = 0;
        while ($i < $left && $j < $right)
        {
            if ($a[$i] < $a[$j])
                $temp[$k++] = $a[$i++];
            else
                $temp[$k++] = $a[$j++];
        }
        while ($i < $left)
            $temp[$k++] = $a[$i++];
        while ($j < $right)
            $temp[$k++] = $a[$j++];
        for ($k = 0; $k < $m + $n; ++$k)
            $a[$pos + $k] = $temp[$k];
    }

//{
    /**
     * Sorts (in place) a contiguous region in array of Comparable objects.
     *
     * @param array $a The array of comparable objects to be sorted.
     * @param integer $i The position of the left-most element to be sorted.
     * @param integer $n The length of the region to be sorted.
     */
    public static function mergeSort(&$a, $i, $n)
    {
        if ($n > 1)
        {
            $n2 = intval($n / 2);
            self::mergeSort($a, $i, $n2);
            self::mergeSort($a, $i + $n2, $n - $n2);
            self::merge ($a, $i, $n2, $n - $n2);
        }
    }
//}>q

//{
    /**
     * Returns the n-th Fibonacci number of order k.
     * Uses a dynamic-programming algorithm.
     * @param integer $n The value of n.
     * @param integer $k The value of k.
     * @return integer The n-th Fibonacci number of order k.
     */
    //[
    public static function fibonacci4($n, $k)
    //]
    //!public static function fibonacci($n, $k)
    {
        if ($n < $k - 1)
            return 0;
        else if ($n == $k - 1)
            return 1;
        else
        {
            $f = array();
            for ($i = 0; $i < $k - 1; ++$i)
                $f[$i] = 0;
            $f[$k - 1] = 1;
            for ($i = $k; $i <= $n; ++$i)
            {
                $sum = 0;
                for ($j = 1; $j <= $k; ++$j)
                    $sum += $f[$i - $j];
                $f[$i] = $sum;
            }
            return $f[$n];
        }
    }
//}>r

//{
    /**
     * Returns the binomial coefficient, n choose m.
     * Uses a dynamic-programming algorithm.
     * @param integer $n The value of n.
     * @param integer $m The value of m.
     * @return float The binomial coefficient, n choose m.
     */
    public static function binom($n, $m)
    {
        $b = array();
        $b[0] = 1;
        for ($i = 1; $i <= $n; ++$i)
        {
            $b[$i] = 1;
            for ($j = $i - 1; $j > 0; --$j)
                $b[$j] += $b[$j - 1];
        }
        return $b[$m];
    }
//}>s

//{
    /**
     * Finds the optimum way to typeset a justified paragraph.
     *
     * @param array $l The lengths of the words in the paragraph.
     * @param integer $D The length of a line.
     * @param integer $s The length of the normal interword space.
     */
    public static function typeset($l, $D, $s)
    {
        $n = count($l);
        $L = array();
        for ($i = 0; $i < $n; ++$i)
        {
            $L[$i] = array();
            $L[$i][$i] = $l[$i];
            for ($j = $i + 1; $j < $n; ++$j)
                $L[$i][$j] = $L[$i][$j - 1] + $l[$j];
        }
        $P = array();
        for ($i = 0; $i < $n; ++$i)
        {
            $P[$i] = array();
            for ($j = $i; $j < $n; ++$j)
            {
                if ($L[$i][$j] < $D)
                    $P[$i][$j] = abs($D-$L[$i][$j]-($j-$i)*$s);
                else
                    $P[$i][$j] = Limits::MAXINT;
            }
        }
        $c = array();
        for ($j = 0; $j < $n; ++$j)
        {
            $c[j] = array();
            $c[$j][$j] = $P[$j][$j];
            for ($i = $j - 1; $i >= 0; --$i)
            {
                $min = $P[$i][$j];
                for ($k = $i; $k < $j; ++$k)
                {
                    $tmp = $P[$i][$k] + $c[$k + 1][$j];
                    if ($tmp < $min)
                        $min = $tmp;
                }
                $c[$i][$j] = $min;
            }
        }
    //[    
        for ($i = 0; $i < $n; ++$i)
        {
            for ($j = $i; $j < $n; ++$j)
                printf("%s ", $c[$i][$j]);
            printf("\n");
        }
    //]
    }
//}>t

//{
    /**
     * Computes the value of pi.
     * Uses a monte-carlo algorithm.
     *
     * @param integer $trials The number of trials to be done.
     * @return float The value of pi.
     */
    public static function computePi($trials)
    {
        $hits = 0;
        for ($i = 0; $i < $trials; ++$i)
        {
            $x = RandomNumberGenerator::next();
            $y = RandomNumberGenerator::next();
            if ($x * $x + $y * $y < 1.0)
                ++$hits;
        }
        return 4.0 * $hits / $trials;
    }
//}>u
}

//{
/**
 * Simple method to illustrate parameter passing with primitive types.
 * @ignore
 */
function one()
{
    $y = 1;
    printf("%s\n", $y);
    two($y);
    printf("%s\n", $y);
}

/**
 * Simple method to illustrate parameter passing with primitive types.
 * @ignore
 */
function two($x)
{
    $x = 2;
    printf("%s\n", $x);
}
//}>v

//{
/**
 * Simple object used to illustrate parameter passing with reference types.
 *
 * @package Opus11
 * @ignore
 */
class Obj
{
    /**
     * An integer-valued field.
     */
    protected $field = 0;

    /**
     * Constructs an Obj with the specified value.
     * @param integer $arg The specified value.
     */
    public function __construct($arg)
        { $this->field = $arg; }
    /**
     * Assigns the specified value to the integer-valued field.
     * @param integer $arg the value to be assigned.
     */
    public function setField($arg)
        { $this->field = $arg; }
    /**
     * Returns a string representation of this object.
     */
    public function __toString()
        { return strval($this->field); }
}

//[
/**
 * Simple method to illustrate parameter passing with reference types.
 * @ignore
 */
function one2()
//]
//!function one()
{
    $y = new Obj(1);
    printf("%s\n", str($y));
    //!two($y);
//[
    two2($y);
//]
    printf("%s\n", str($y));
}

//[
/**
 * Simple method to illustrate parameter passing with reference types.
 * @ignore
 */
function two2(Obj $x)
//]
//!function two(Obj x)
{
    $x->setField(2);
    printf("%s\n", str($x));
}
//}>w

//{
/**
 * A minimal Throwable class.
 *
 * @package Opus11
 * @ignore
 */
class A extends Exception 
{
    public function __construct()
    {
        parent::__construct(__CLASS__);
    }
}

/**
 * Throws an instance of the A class.
 * @ignore
 */
function f()
{
    throw new A();
}

/**
 * Illustrates how to catch an exception.
 * Calls f and catches the A that it throws.
 * @ignore
 */
function g()
{
    try
    {
        f();
    }
    catch (A $exception)
    {
        // ...
    }
}
//}>x

if (realpath($argv[0]) == realpath(__FILE__))
{
printf("sum(10) = %d\n",
        Example::sum(10));
printf("horner([2,4,6], 2, 57) = %d\n",
        Example::horner(array(2,4,6), 2, 57));
printf("horner2([2,4,6], 2, 57) = %d\n",
        Example::horner2(array(2,4,6), 2, 57));
printf("factorial(10) = %d\n",
        Example::factorial(10));
printf("findMaximum([3,1,4,1,5,9,2], 7) = %d\n",
        Example::findMaximum(array(3,1,4,1,5,9,2), 7));
printf("gamma = %f\n",
        Example::gamma());
printf("geometricSeriesSum1(10, 6) = %d\n",
        Example::geometricSeriesSum(10, 6));
printf("geometricSeriesSum2(10, 6) = %d\n",
        Example::geometricSeriesSum2(10, 6));
printf("geometricSeriesSum3(10, 6) = %d\n",
        Example::geometricSeriesSum3(10, 6));
$arg = array(2,4,6,8);
Example::prefixSums($arg, 4);
printf("prefixSums([2,4,6,8], 4) = %s\n",
        join(',', $arg));
printf("fibonacci1(5) = %d\n",
        Example::fibonacci(10));
printf("fibonacci2(5) = %d\n",
        Example::fibonacci2(10));
printf("fibonacci3(5) = %d\n",
        Example::fibonacci3(10));
printf("fibonacci4(5, 2) = %d\n",
        Example::fibonacci4(10, 2));
$arg = array(3,1,4,1,5,9,2);
$buckets = array(0,0,0,0,0,0,0,0,0,0);
Example::bucketSort($arg, 7, $buckets, 10);
printf("bucketSort({3,1,4,1,5,9,2}, 10) = %s\n",
        join(',', $arg));
$arg = array(3,1,4,1,5,9,2);
Example::mergeSort($arg, 0, 7);
printf("mergeSort({3,1,4,1,5,9,2}, 10) = %s\n",
        join(',', $arg));
printf("binarySearch({1,1,2,3,4,5,9}, 5, 0, 7) = %s\n",
    Example::binarySearch(array(1,1,2,3,4,5,9), 5, 0, 7));
printf("binom(5, 2) = %d\n",
        Example::binom(5, 2));
printf("computePi(10000) = %f\n",
        Example::computePi(10000));
one();
one2();
g();
}
?>
