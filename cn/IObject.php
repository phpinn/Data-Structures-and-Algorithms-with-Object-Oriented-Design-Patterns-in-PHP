<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IObject.php,v 1.8 2005/12/09 01:11:13 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Exceptions.php';

//{
/**
 * Interface implemented by all objects.
 */
interface IObject
{
    /**
     * Returns a unique identifier for this object.
     * @return integer An identifier.
     */
    public abstract function getId();
    /**
     * Returns a hash code for this object.
     * @return integer A hash code. 
     */
    public abstract function getHashCode();
    /**
     * Returns the class of this object.
     * @return object ReflectionClass A ReflectionClass.
     */
    public abstract function getClass();
}
//}>a

//{
/**
 * Returns a hash code for the given item.
 * @param mixed item An item.
 * @return integer A hash code.
 */
function hash($item)
{
    $type = gettype($item);
    if ($type == 'object')
    {
        return $item->getHashCode();
    }
    elseif ($type == 'NULL')
    {
        return 0;
    }
    else
    {
        throw new ArgumentError();
    }
}
//}>b

//{
/**
 * Returns a textual representation of the given item.
 * @param mixed item An item.
 * @return string A string.
 */
function str($item)
{
    $type = gettype($item);
    if ($type == 'boolean')
    {
        return $item ? 'true' : 'false';
    }
    elseif ($type == 'object')
    {
        return $item->__toString();
    }
    elseif ($type == 'NULL')
    {
        return 'NULL';
    }
    else
    {
        return strval($item);
    }
}
//}>c
?>
