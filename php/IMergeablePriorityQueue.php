<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IMergeablePriorityQueue.php,v 1.4 2005/12/09 01:11:12 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IPriorityQueue.php';

//{
/**
 * Interface implemented by all mergeable priority queues.
 *
 * @package Opus11
 */
interface IMergeablePriorityQueue
    extends IPriorityQueue
{
    /**
     * Merges the contents of given priority queue into this priority queue.
     *
     * @param object IMergeablePriorityQueue $queue A mergeable priority queue.
     */
    public abstract function merge(
        IMergeablePriorityQueue $queue);
}
//}>a
?>
