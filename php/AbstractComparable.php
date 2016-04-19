<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractComparable.php,v 1.12 2005/12/09 01:11:02 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractObject.php';
require_once 'Opus11/IComparable.php';

//{
/**
 * Abstract base class from which all comparable object classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractComparable
    extends AbstractObject
    implements IComparable
{
//}@head

//{
//!    // ...
//!}
//}@tail

    /**
     * Constructs an AbstractComparable.
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
     * Returns true if this object is equal to the given object.
     * 
     * @param object IComparable $object A comparable object.
     * @return boolean True if this object is equal to the given object.
     */
    public function eq(IComparable $object)
    {
        return $this->compare($object) == 0;
    }

    /**
     * Returns true if this object is not equal to the given object.
     * 
     * @param object IComparable $object A comparable object.
     * @return boolean True if this object is not equal to the given object.
     */
    public function ne(IComparable $object)
    {
        return $this->compare($object) != 0;
    }
    
    /**
     * Returns true if this object is less than the given object.
     * 
     * @param object IComparable $object A comparable object.
     * @return boolean True if this object is less than the given object.
     */
    public function lt(IComparable $object)
    {
        return $this->compare($object) < 0;
    }
    
    /**
     * Returns true if this object is less than or equal to the given object.
     * 
     * @param object IComparable $object A comparable object.
     * @return boolean True if this object is
     * less than or equal to the given object.
     */
    public function le(IComparable $object)
    {
        return $this->compare($object) <= 0;
    }

    /**
     * Returns true if this object is greater than the given object.
     * 
     * @param object IComparable $object A comparable object.
     * @return boolean True if this object is greater than the given object.
     */
    public function gt(IComparable $object)
    {
        return $this->compare($object) > 0;
    }
    
    /**
     * Returns true if this object is greater than or equal to the given object.
     * 
     * @param object IComparable $object A comparable object.
     * @return boolean True if this object is
     * greater than or equal to the given object.
     */
    public function ge(IComparable $object)
    {
        return $this->compare($object) >= 0;
    }
//}>a

//{
    /**
     * Compares this object with the given object.
     * This object and the given object are instances of the same class.
     *
     * @param object IComparable $object The given object.
     * @return integer A number less than zero
     * if this object is less than the given object,
     * zero if this object equals the given object, and
     * a number greater than zero
     * if this object is greater than the given object.
     */
    protected abstract function compareTo(IComparable $object);

    /**
     * Compares this object with the given object.
     *
     * @param object IComparable $object A comparable object.
     * @return integer A number less than zero
     * if this object is less than the given object,
     * zero if this object equals the given object, and
     * a number greater than zero
     * if this object is greater than the given object.
     */
    public function compare(IComparable $object)
    {
        $result = 0;
        if ($this->getClass() == $object->getClass())
        {
            $result = $this->compareTo($object);
        }
        else
        {
            $result = strcmp(
                $this->getClass()->getName(),
                $object->getClass()->getName());
        }
        return $result;
    }
//}>b

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on succes; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractComparable main program.\n");
        return 0;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractComparable::main(array_slice($argv, 1)));
}
?>
