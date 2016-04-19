<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: BoxedInteger.php,v 1.12 2005/12/09 01:11:08 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Box.php';

//{
/**
 * Represents an integer.
 *
 * @package Opus11
 */
class BoxedInteger
    extends Box
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a BoxedInteger with the given value.
     *
     * @param integer $value A value.
     */
    public function __construct($value)
    {
        parent::__construct(intval($value));
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
     * @param integer $value A value.
     */
    public function setValue($value)
    {
        $this->value = intval($value);
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
     * Returns a hash of the value of this BoxedInteger.
     *
     * @return integer An integer.
     */
    public function getHashCode()
    {
        return $this->value;
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
        printf("BoxedInteger main program.\n");
        $status = 0;
        $i1 = new BoxedInteger(57);
        printf("i1 = %s\n", str($i1));
        $i2 = new BoxedInteger(123);
        printf("i2 = %s\n", str($i2));
        printf("i1 < i2 = %s\n", str(lt($i1, $i2)));
        printf("hash(i1) = %d\n", hash($i1));
        printf("hash(i2) = %d\n", hash($i2));
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(BoxedInteger::main(array_slice($argv, 1)));
}
?>
