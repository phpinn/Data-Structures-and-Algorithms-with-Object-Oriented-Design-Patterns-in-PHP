<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractObject.php,v 1.10 2005/12/09 01:11:03 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IObject.php';

//{
/**
 * Abstract base class from which all object classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractObject
    implements IObject
{
//}@head

//{
//!    // ...
//!}
//}@tail

    /**
     * Constructs an AbstractObject.
     */
    public function __construct()
    {
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
    }

//{
    /**
     * Returns a unique identifier for this object.
     *
     * @return integer An identifier.
     */
    public function getId()
    {
        preg_match('/^Object id #(\d*)$/',
            strval($this), $matches);
        return intval($matches[1]);
    }
//}>a

//{
    /**
     * Returns the class of this object.
     *
     * @return object ReflectionClass A ReflectionClass.
     */
    public function getClass()
    {
        return new ReflectionClass(get_class($this));
    }
//}>b

    /**
     * Returns a hash code for this object.
     *
     * @return integer A hash code.
     */
    public function getHashCode()
    {
        return $this->getId();
    }

    /**
     * Returns a textual representation of this object.
     *
     * @return string A string.
     */
    public function __toString()
    {
        return $this->getClass()->getName() . '{' . strval($this) . '}';
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractObject main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractObject::main(array_slice($argv, 1)));
}
?>
