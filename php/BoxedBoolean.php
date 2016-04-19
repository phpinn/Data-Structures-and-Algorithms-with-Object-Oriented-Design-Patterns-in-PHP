<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: BoxedBoolean.php,v 1.13 2005/12/09 01:11:07 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Box.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * Represents a boolean value.
 *
 * @package Opus11
 */
class BoxedBoolean
    extends Box
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a BoxedBoolean with the given boolean value.
     *
     * @param boolean $value A boolean value.
     */
    public function __construct($value)
    {
        parent::__construct($value ? true : false);
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
     * @param value A value.
     */
    public function setValue($value)
    {
        $this->value = $value ? true : false;
    }

    /**
     * Compares this BoxedBoolean with the given object.
     * This given object must be a BoxedBoolean.
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
        return ($this->value ? 1 : 0) - ($obj->value ? 1 : 0);
    }

    /**
     * Returns a textual representation of this BoxedBoolean.
     *
     * @return string A string.
     */
    public function __toString()
    {
        return str($this->value);
    }
//}>a

//{
    /**
     * Returns a hash of the value of this BoxedBoolean.
     *
     * @return integer An integer.
     */
    public function getHashCode()
    {
        return $this->value ? 1 : 0;
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
        printf("BoxedBoolean main program.\n");
        $status = 0;
        $b1 = new BoxedBoolean(false);
        printf("b1 = %s\n", str($b1));
        $b2 = new BoxedBoolean(true);
        printf("b2 = %s\n", str($b2));
        printf("b1 < b2 = %s\n", str(lt($b1,$b2)));
        printf("hash(b1) = %d\n", hash($b1));
        printf("hash(b2) = %d\n", hash($b2));
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(BoxedBoolean::main(array_slice($argv, 1)));
}
?>
