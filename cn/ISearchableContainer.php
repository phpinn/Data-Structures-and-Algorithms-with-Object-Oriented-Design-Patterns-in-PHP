<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ISearchableContainer.php,v 1.6 2005/11/28 00:38:35 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IContainer.php';

//{
/**
 * Interface implemented by all searchable containers.
 *
 * @package Opus11
 */
interface ISearchableContainer
    extends IContainer
{
    /**
     * Returns true if this container contains the given object instance.
     *
     * @param object IComparable $obj The object to find.
     * @return True if this container contains the given object;
     * false otherwise.
     */
    public abstract function contains(IComparable $obj);
    /**
     * Inserts the specified object into this container.
     *
     * @param object IComparable $obj The object to insert.
     */
    public abstract function insert(IComparable $obj);
    /**
     * Withdraws the given object instance from this container.
     *
     * @param object IComparable $obj The object to withdraw.
     */
    public abstract function withdraw(IComparable $obj);
    /**
     * Finds the object in this container that equals the given object.
     *
     * @param object IComparable $obj The object to match.
     * @return mixed The object that equasl the given object.
     */
    public abstract function find(IComparable $obj);
}
//}>a
?>
