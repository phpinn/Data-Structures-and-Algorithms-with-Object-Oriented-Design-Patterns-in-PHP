<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IStack.php,v 1.7 2005/11/27 23:32:33 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IContainer.php';

//{
/**
 * Interface implemented by all stacks.
 *
 * @package Opus11
 */
interface IStack
    extends IContainer
{
    /**
     * Pushes the given object onto this stack.
     *
     * @param object IObject $obj The object to push.
     */
    public abstract function push(IObject $obj);
    /**
     * Pops and returns the top object from this stack.
     *
     * @return object IObject The top object.
     */
    public abstract function pop();
    /**
     * Top getter.
     *
     * @return object IObject The top object on this stack.
     */
    public abstract function getTop();
}
//}>a
?>
