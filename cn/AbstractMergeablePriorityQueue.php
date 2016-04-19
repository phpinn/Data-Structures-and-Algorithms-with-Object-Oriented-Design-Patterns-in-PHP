<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractMergeablePriorityQueue.php,v 1.5 2005/12/09 01:11:03 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractPriorityQueue.php';
require_once 'Opus11/IMergeablePriorityQueue.php';
require_once 'Opus11/Box.php';

//{
/**
 * Abstract base class from which mergeable priority queue classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractMergeablePriorityQueue
    extends AbstractPriorityQueue
    implements IMergeablePriorityQueue
{

//!    // ...
//!}
//}>a

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractMergeablePriorityQueue main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractMergeablePriorityQueue::main(array_slice($argv, 1)));
}
?>
