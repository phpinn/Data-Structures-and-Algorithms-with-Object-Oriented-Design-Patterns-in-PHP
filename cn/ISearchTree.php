<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ISearchTree.php,v 1.3 2005/11/27 23:32:33 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/ITree.php';
require_once 'Opus11/ISearchableContainer.php';

//{
/**
 * Interface implemented by all trees.
 *
 * @package Opus11
 */
interface ISearchTree
    extends ITree, ISearchableContainer
{
    /**
     * Returns the "smallest" object in this tree.
     * The smallest object in this tree is the one which is less
     * than all the rest.
     *
     * @return object IComparable The smallest object in this tree.
     */
    public abstract function findMin();
    /**
     * Returns the "largest" object in this tree.
     * The largest object in this tree is the one which is greater
     * than all the rest.
     *
     * @return object IComparable The largest object in this tree.
     */
    public abstract function findMax();
}
//}>a
?>
