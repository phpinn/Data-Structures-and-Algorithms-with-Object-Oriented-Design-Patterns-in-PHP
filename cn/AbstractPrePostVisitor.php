<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractPrePostVisitor.php,v 1.6 2005/12/09 01:11:03 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IPrePostVisitor.php';

//{
/**
 * Abstract base class from which all pre/post visitor classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractPrePostVisitor
    implements IPrePostVisitor
{
    /**
     * Constructs this AbstractPrePostVisitor.
     */
    public function __construct()
    {
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
    }

    /**
     * Default preVisit method does nothing.
     *
     * @param object IObject $obj An object.
     */
    public function preVisit(IObject $obj)
    {
    }

    /**
     * Default inVisit method does nothing.
     *
     * @param object IObject $obj An object.
     */
    public function inVisit(IObject $obj)
    {
    }

    /**
     * Default postVisit method does nothing.
     *
     * @param object IObject $obj An object.
     */
    public function postVisit(IObject $obj)
    {
    }

    /**
     * Done predicate.
     *
     * @return boolean False always.
     */
    public function isDone()
    {
        return false;
    }
}
//}>a
?>
