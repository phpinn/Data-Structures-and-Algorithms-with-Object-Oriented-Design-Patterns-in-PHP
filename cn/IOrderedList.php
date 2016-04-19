<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IOrderedList.php,v 1.5 2005/11/27 23:32:32 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/ISearchableContainer.php';

//{
/**
 * Interface implemented by all ordered lists.
 *
 * @package Opus11
 */
interface IOrderedList
    extends ISearchableContainer, ArrayAccess
{
    /**
     * Returns the position in this list of the given object.
     *
     * @param object IComparable $obj The object to find.
     * @return object ICursor A cursor.
     */
    public abstract function findPosition(IComparable $obj);
}
//}>a
?>
