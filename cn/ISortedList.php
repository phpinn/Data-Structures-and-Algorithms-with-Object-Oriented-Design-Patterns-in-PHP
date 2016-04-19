<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ISortedList.php,v 1.3 2005/11/27 23:32:33 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/ISearchableContainer.php';

//{
/**
 * Interface implemented by all sorted lists.
 *
 * @package Opus11
 */
interface ISortedList
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
