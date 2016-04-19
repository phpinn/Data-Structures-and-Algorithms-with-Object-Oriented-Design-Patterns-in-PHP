<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IHashTable.php,v 1.3 2005/11/27 23:32:31 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/ISearchableContainer.php';

//{
/**
 * Interface implemented by all hash tables.
 *
 * @package Opus11
 */
interface IHashTable
    extends ISearchableContainer
{
    /**
     * Load factor getter.
     *
     * @return float The current load factor.
     */
    public abstract function getLoadFactor();
}
//}>a
?>
