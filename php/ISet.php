<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ISet.php,v 1.3 2005/11/27 23:32:33 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/ISearchableContainer.php';

//{
/**
 * Interface implemented by all sets.
 *
 * @package Opus11
 */
interface ISet
    extends ISearchableContainer
{
    /**
     * Insert the given item into this set.
     *
     * @param integer $item The item to insert.
     */
    public abstract function insertItem($item);
    /**
     * Withdraws the given item from this set.
     *
     * @param integer $item The item to withdraw.
     */
    public abstract function withdrawItem($item);
    /**
     * ContainsItem predicate.
     *
     * @return boolean True if this set contains the given item.
     */
    public abstract function containsItem($item);
    /**
     * Returns the union of this set and the specified set.
     *
     * @param object ISet $set The set to be joined with this set.
     * @return object ISet The union of this set and the specified set.
     */
    public abstract function union(ISet $set);
    /**
     * Returns the intersection of this set and the specified set.
     *
     * @param object ISet $set The set to be intersected with this set.
     * @return object ISet The intersection of this set and the specified set.
     */
    public abstract function intersection(ISet $set);
    /**
     * Returns the difference between this set and the specified set.
     *
     * @param object ISet $set The set to subtract from this set.
     * @return object ISet
     * The difference between this set and the specified set.
     */
    public abstract function difference(ISet $set);
    /**
     * Tests whether this set is a subset of the specified set.
     *
     * @param object ISet $set The set to which this set is compared.
     * @return boolean True if this set is a subset of the specified set;
     * false otherwise.
     */
    public abstract function isSubset(ISet $set);
}
//}>a
?>
