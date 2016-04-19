<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ICursor.php,v 1.4 2005/11/27 23:32:31 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IIterator.php';
require_once 'Opus11/IObject.php';

//{
/**
 * Interface implemented by all cursors.
 *
 * @package Opus11
 */
interface ICursor
    extends IIterator
{
    /**
     * Inserts the given object after the position of this cursor.
     *
     * @param object IObject obj The object to insert.
     */
    public abstract function insertAfter(IObject $obj);
    /**
     * Inserts the given object before the position of this cursor.
     *
     * @param object IObject $obj The object to insert.
     */
    public abstract function insertBefore(IObject $obj);
    /**
     * Withdraws the object at the position of this cursor.
     */
    public abstract function withdraw();
}
//}>a
?>
