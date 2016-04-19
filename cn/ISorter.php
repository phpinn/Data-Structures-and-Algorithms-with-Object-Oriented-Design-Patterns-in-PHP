<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ISorter.php,v 1.1 2005/12/02 00:12:59 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IObject.php';
require_once 'Opus11/BasicArray.php';

//{
/**
 * Interface implemented by all sorters.
 * A sorter is an abstract machine that sorts an array of comparable objects.
 *
 * @package Opus11
 */
interface ISorter
    extends IObject
{
    /**
     * Sorts the specified array of comparable
     * objects from "smallest" to "largest".
     *
     * @param object BasicArray $array The array of objects to be sorted.
     */
    public abstract function sort(BasicArray $array);
}
//}>a
?>
