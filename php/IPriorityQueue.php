<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IPriorityQueue.php,v 1.3 2005/11/27 23:32:32 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IContainer.php';

//{
/**
 * Interface implemented by all priority queues.
 *
 * @package Opus11
 */
interface IPriorityQueue
    extends IContainer
{
    /**
     * Enqueues the given object at the tail of this queue.
     *
     * @param object IComparable $obj The object to enqueue.
     */
    public abstract function enqueue(IComparable $obj);
    /**
     * Dequeues and returns the smallest object in this queue.
     *
     * @return object IComparable The smallest object in this queue.
     */
    public abstract function dequeueMin();
    /**
     * Finds and returns the smallest object in this queue.
     *
     * @return object IComparable The smallest object in this queue.
     */
    public abstract function findMin();
}
//}>a
?>
