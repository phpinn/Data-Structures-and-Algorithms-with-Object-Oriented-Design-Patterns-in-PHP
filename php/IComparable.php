<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IComparable.php,v 1.13 2005/12/09 01:11:12 brpreiss Exp $
 * @package Opus11
 */

//{
/**
 * Interface implemented by all comparable objects.
 *
 * @package Opus11
 */
interface IComparable
{
    /**
     * Compares this object with the given object.
     *
     * @param object IComparable $object The given object.
     * @return integer A number less than zero
     * if this object is less than the given object,
     * zero if this object equals the given object, and
     * a number greater than zero
     * if this object is greater than the given object.
     */
    public abstract function compare(IComparable $object);
    /**
     * Compares this object with the given object.
     *
     * @param object IComparable $object The given object.
     * @return boolean True if this object is equal to the given object.
     */
    public abstract function eq(IComparable $object);
    /**
     * Compares this object with the given object.
     *
     * @param object IComparable $object The given object.
     * @return boolean True if this object is not equal to the given object.
     */
    public abstract function ne(IComparable $object);
    /**
     * Compares this object with the given object.
     *
     * @param object IComparable $object The given object.
     * @return boolean True if this object is less than the given object.
     */
    public abstract function lt(IComparable $object);
    /**
     * Compares this object with the given object.
     *
     * @param object IComparable $object The given object.
     * @return boolean True if this object is less than or equal to the given object.
     */
    public abstract function le(IComparable $object);
    /**
     * Compares this object with the given object.
     *
     * @param object IComparable $object The given object.
     * @return boolean True if this object is greater than the given object.
     */
    public abstract function gt(IComparable $object);
    /**
     * Compares this object with the given object.
     *
     * @param object IComparable $object The given object.
     * @return boolean True if this object is greater than or equal to the given object.
     */
    public abstract function ge(IComparable $object);
}
//}>a

//{
/**
 * Returns true if the given items compare equal.
 *
 * @param mixed $left An item.
 * @param mixed $right An item.
 * @return boolean True if the given items are equal.
 */
function eq($left, $right)
{
    if (gettype($left) == 'object' &&
        gettype($right) == 'object')
    {
        return $left->eq($right);
    }
    else
    {
        return $left == $right;
    }
}
//}>b

/**
 * Returns true if the given items compare not equal.
 *
 * @param mixed $left An item.
 * @param mixed $right An item.
 * @return boolean True if the given items are not equal.
 */
function ne($left, $right)
{
    if (gettype($left) == 'object' &&
        gettype($right) == 'object')
    {
        return $left->ne($right);
    }
    else
    {
        return $left != $right;
    }
}

/**
 * Returns true if the left item is greater than the right item.
 *
 * @param mixed $left An item.
 * @param mixed $right An item.
 * @return boolean True if the given items are equal.
 */
function gt($left, $right)
{
    if (gettype($left) == 'object' &&
        gettype($right) == 'object')
    {
        return $left->gt($right);
    }
    else
    {
        return $left > $right;
    }
}

/**
 * Returns true if the left item is greater than or equal to the right item.
 *
 * @param mixed $left An item.
 * @param mixed $right An item.
 * @return boolean True if the given items are equal.
 */
function ge($left, $right)
{
    if (gettype($left) == 'object' &&
        gettype($right) == 'object')
    {
        return $left->ge($right);
    }
    else
    {
        return $left >= $right;
    }
}

/**
 * Returns true if the left item is less than the right item.
 *
 * @param mixed $left An item.
 * @param mixed $right An item.
 * @return boolean True if the given items are equal.
 */
function lt($left, $right)
{
    if (gettype($left) == 'object' &&
        gettype($right) == 'object')
    {
        return $left->lt($right);
    }
    else
    {
        return $left < $right;
    }
}

/**
 * Returns true if the left item is less than or equal to the right item.
 *
 * @param mixed $left An item.
 * @param mixed $right An item.
 * @return boolean True if the given items are equal.
 */
function le($left, $right)
{
    if (gettype($left) == 'object' &&
        gettype($right) == 'object')
    {
        return $left->le($right);
    }
    else
    {
        return $left <= $right;
    }
}
?>
