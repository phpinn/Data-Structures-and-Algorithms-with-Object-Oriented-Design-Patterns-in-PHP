<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IDoubleEndedPriorityQueue.php,v 1.3 2005/11/27 23:32:31 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IPriorityQueue.php';

//{
/**
 * Interface implemented by all double-ended priority queues.
 *
 * @package Opus11
 */
interface IDoubledEndedPriorityQueue
    extends IPriorityQueue
{
    /**
     * Dequeues and returns the largest object in this queue.
     *
     * @return object IComparable The largest object in this queue.
     */
    public abstract function dequeueMax();
    /**
     * Finds and returns the largest object in this queue.
     *
     * @return object IComparable The largest object in this queue.
     */
    public abstract function findMax();
}
//}>a
?>
