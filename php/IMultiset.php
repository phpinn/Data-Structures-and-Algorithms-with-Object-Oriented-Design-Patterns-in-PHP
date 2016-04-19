<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IMultiset.php,v 1.3 2005/11/27 23:32:32 brpreiss Exp $
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
interface IMultiset
    extends ISearchableContainer
{
    /**
     * Insert the given item into this set.
     *
     * @param integer item The item to insert.
     */
    public abstract function insertItem($item);
    /**
     * Withdraws the given item from this set.
     *
     * @param integer item The item to withdraw.
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
     * @param object IMultiset $set The set to be joined with this set.
     * @return object IMultiset The union of this set and the specified set.
     */
    public abstract function union(IMultiset $set);
    /**
     * Returns the intersection of this set and the specified set.
     *
     * @param object IMultiset $set The set to be intersected with this set.
     * @return object IMultiset
     * The intersection of this set and the specified set.
     */
    public abstract function intersection(IMultiset $set);
    /**
     * Returns the difference between this set and the specified set.
     *
     * @param object IMultiset $set The set to subtract from this set.
     * @return object IMultiset
     * The difference between this set and the specified set.
     */
    public abstract function difference(IMultiset $set);
    /**
     * Tests whether this set is a subset of the specified set.
     *
     * @param object IMultiset $set The set to which this set is compared.
     * @return boolean True if this set is a subset of the specified set;
     * false otherwise.
     */
    public abstract function isSubset(IMultiset $set);
}
//}>a
?>
