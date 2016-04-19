<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IIterator.php,v 1.3 2005/11/27 23:32:32 brpreiss Exp $
 * @package Opus11
 */

//{
/**
 * Interface implemented by all iterators.
 *
 * @package Opus11
 */
interface IIterator
    extends Iterator
{
    /**
     * Returns the next object to be enumerated by this iterator.
     * Returns NULL when there are not more objects.
     *
     * @return mixed The next object to be enumerated.
     */
    public abstract function succ();
}
//}>a
?>
