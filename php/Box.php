<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Box.php,v 1.11 2005/12/09 01:11:07 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractComparable.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * Abstract base class from which all boxed value classes are derived.
 *
 * @package Opus11
 */
abstract class Box
    extends AbstractComparable
{
    /**
     * $var mixed The boxed value.
     */
    protected $value = NULL;

    /**
     * Constructs a Box with the given value.
     *
     * @param mixed $value A value.
     */
    public function __construct($value)
    {
        parent::__construct();
        $this->value = $value;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Value getter.
     *
     * @return mixed Return the value of this box.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns a textual representation of the value in this box.
     *
     * @return string A string.
     */
    public function __toString()
    {
        return strval($this->value);
    }
//!}
//}>a

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Box main program.\n");
        $status = 0;
        $box = box(false);
        printf("%s\n", str($box));
        $box = box(57);
        printf("%s\n", str($box));
        $box = box(1.5);
        printf("%s\n", str($box));
        $box = box('test');
        printf("%s\n", str($box));
        $box = box(array(1,2,3));
        printf("%s\n", str($box));
        return $status;
    }
}

require_once 'Opus11/BoxedBoolean.php';
require_once 'Opus11/BoxedInteger.php';
require_once 'Opus11/BoxedFloat.php';
require_once 'Opus11/BoxedString.php';
require_once 'Opus11/BasicArray.php';

//{
/**
 * Boxes the given value.
 *
 * @param mixed $value A value.
 * @return object Box A boxed value.
 */
function box($value)
{
    $type = gettype($value);
    if ($type == 'boolean')
    {
        return new BoxedBoolean($value);
    }
    elseif ($type == 'integer')
    {
        return new BoxedInteger($value);
    }
    elseif ($type == 'float' || $type == 'double')
    {
        return new BoxedFloat($value);
    }
    elseif ($type == 'string')
    {
        return new BoxedString($value);
    }
    elseif ($type == 'array')
    {
        return new BasicArray($value);
    }
    else
    {
        throw new TypeError();
    }
}

/**
 * Unboxes the given value.
 *
 * @param object Box box A boxed value.
 * @return mixed The value in the box.
 */
function unbox($box)
{
    return $box->getValue();
}
//}>b

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Box::main(array_slice($argv, 1)));
}
?>
