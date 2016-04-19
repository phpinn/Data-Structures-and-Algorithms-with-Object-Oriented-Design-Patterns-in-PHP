<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IPrePostVisitor.php,v 1.3 2005/11/27 23:32:32 brpreiss Exp $
 * @package Opus11
 */

//{
/**
 * Interface implemented by all pre/post visitors.
 *
 * @package Opus11
 */
interface IPrePostVisitor
{
    /**
     * "Pre"-visits the given object.
     *
     * @param object IObject $obj The object to visit.
     */
    public abstract function preVisit(IObject $obj);
    /**
     * "In"-visits the given object.
     *
     * @param object IObject $obj The object to visit.
     */
    public abstract function inVisit(IObject $obj);
    /**
     * "Post"-visits the given object.
     *
     * @param object IObject $obj The object to visit.
     */
    public abstract function postVisit(IObject $obj);
    /**
     * Done predicate.
     *
     * @return boolean True if this visitor is done.
     */
    public abstract function isDone();
}
//}>a
?>
