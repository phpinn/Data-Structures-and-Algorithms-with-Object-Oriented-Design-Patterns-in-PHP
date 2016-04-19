<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IPartition.php,v 1.1 2005/11/30 01:20:42 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/ISet.php';

//{
/**
 * Interface implemented by all partitions.
 *
 * @package Opus11
 */
interface IPartition
    extends ISet
{
    /**
     * Returns the element of this partition that contains the specified item.
     *
     * @param integer An item.
     * @return object ISet The element of this partition that contains the item.
     */
    public abstract function findItem($item);
    /**
     * Joins two specified elements of this partition.
     *
     * @param object ISet $set1 An element of this partition.
     * @param object ISet $set2 An element of this partition.
     */
    public abstract function join(ISet $set1, ISet $set2);
}
//}>a
?>
