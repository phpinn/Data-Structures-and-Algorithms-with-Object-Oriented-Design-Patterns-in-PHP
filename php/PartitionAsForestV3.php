<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: PartitionAsForestV3.php,v 1.2 2005/12/09 01:11:14 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/PartitionAsForestV2.php';

//{
/**
 * A partition implemented as a forest of trees.
 * Implements "union-by-rank".
 *
 * @package Opus11
 */
class PartitionAsForestV3
    extends PartitionAsForestV2
{
//}@head

//{
//!    // ...
//!}
//}@tail

    /**
     * Constructs a PartitionAsForest
     * with the specified number of elements in its universal set.
     *
     * @param integer $n The size of elements in the universal set.
     */
    public function __construct($n)
    {
        parent::__construct($n);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

//{
    /**
     * Joins the specified elements of this partition.
     * Implements "union-by-rank".
     *
     * @param object ISet $p An element of this partition.
     * @param object ISet $q An element of this partition.
     */
    public function join(ISet $p, ISet $q)
    {
        $this->checkArguments($p, $q);
        if ($p->getRank() > $q->getRank())
            $q->setParent($p);
        else
        {
            $p->setParent($q);
            if ($p->getRank() == $q->getRank())
                $q->setRank($q->getRank() + 1);
        }
        --$this->count;
    }
//}>a

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("PartitionAsForestV3 main program.\n");
        $status = 0;
        $p = new PartitionAsForestV3(5);
        AbstractPartition::test($p);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(PartitionAsForestV3::main(array_slice($argv, 1)));
}
?>
