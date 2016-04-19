<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IQueue.php,v 1.8 2005/11/27 23:32:32 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IContainer.php';

//{
/**
 * Interface implemented by all queues.
 *
 * @package Opus11
 */
interface IQueue
    extends IContainer
{
    /**
     * Enqueues the given object at the tail of this queue.
     *
     * @param object IObject $obj The object to enqueue.
     */
    public abstract function enqueue(IObject $obj);
    /**
     * Dequeues and returns the object at the head of this queue.
     *
     * @return object IObject The object at the head of this queue.
     */
    public abstract function dequeue();
    /**
     * Head getter.
     *
     * @return object IObject The object at the head of this queue.
     */
    public abstract function getHead();
}
//}>a
?>
