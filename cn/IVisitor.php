<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IVisitor.php,v 1.3 2005/11/27 23:32:33 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IObject.php';

//{
/**
 * Interface implemented by all visitors.
 *
 * @package Opus11
 */
interface IVisitor
{
    /**
     * Visits the given object.
     *
     * @param object IObject $obj The object to visit.
     */
    public abstract function visit(IObject $obj);
    /**
     * IsDone predicate.
     *
     * @return boolean True if this visitor is done.
     */
    public abstract function isDone();
}
//}>a
?>
