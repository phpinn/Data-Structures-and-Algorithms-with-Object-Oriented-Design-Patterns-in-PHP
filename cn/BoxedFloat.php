<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: BoxedFloat.php,v 1.4 2005/12/09 01:11:08 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Box.php';

//{
/**
 * Represents a float value.
 *
 * @package Opus11
 */
class BoxedFloat
    extends Box
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a BoxedFloat with the given value.
     *
     * @param float $value A value.
     */
    public function __construct($value)
    {
        parent::__construct(floatval($value));
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Value setter.
     *
     * @param float $value A value.
     */
    public function setValue($value)
    {
        $this->value = floatval($value);
    }

    /**
     * Compares this object with the given object.
     * This object and the given object are instances of the same class.
     *
     * @param object IComparable $obj The given object.
     * @return integer A number less than zero
     * if this object is less than the given object,
     * zero if this object equals the given object, and
     * a number greater than zero
     * if this object is greater than the given object.
     */
    protected function compareTo(IComparable $obj)
    {
        return $this->value - $obj->value;
    }
//}>a

//{
    /**
     * Returns a hash of the value of this BoxedFloat.
     *
     * @return integer An integer.
     */
    public function getHashCode()
    {
        $abs = abs($this->value);
        $exponent = intval(log($abs, 2) + 1);
        $mantissa = $abs / pow(2, $exponent);
        $result = intval((2 * $mantissa - 1) * 2147483648);
        return $result;
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
        printf("BoxedFloat main program.\n");
        $status = 0;
        $d1 = new BoxedFloat(1.0);
        printf("d1 = %s\n", str($d1));
        $d2 = new BoxedFloat(0.5);
        printf("d2 = %s\n", str($d2));
        printf("d1 < d2 = %s\n", str(lt($d1, $d2)));
        printf("hash(d1) = %d\n", hash($d1));
        printf("hash(d2) = %d\n", hash($d2));
        printf("hash(57.0) = 0%o\n", hash(new BoxedFloat(57.0)));
        printf("hash(23.0) = 0%o\n", hash(new BoxedFloat(23.0)));
        printf("hash(0.75) = 0%o\n", hash(new BoxedFloat(0.75)));
        printf("hash(-123.0e6) = 0%o\n", hash(new BoxedFloat(-123.0e6)));
        printf("hash(-123.0e7) = 0%o\n", hash(new BoxedFloat(-123.0e7)));
        printf("hash(0.875) = 0%o\n", hash(new BoxedFloat(0.875)));
        printf("hash(14.0) = 0%o\n", hash(new BoxedFloat(14.0)));
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(BoxedFloat::main(array_slice($argv, 1)));
}
?>
