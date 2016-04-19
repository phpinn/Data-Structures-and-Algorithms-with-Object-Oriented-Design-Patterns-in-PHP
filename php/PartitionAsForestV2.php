<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: PartitionAsForestV2.php,v 1.2 2005/12/09 01:11:14 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/PartitionAsForest.php';

//{
/**
 * A partition implemented as a forest of trees.
 * Implements "collapsing find" and "union-by-size".
 *
 * @package Opus11
 */
class PartitionAsForestV2
    extends PartitionAsForest
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
     * Finds the element of this partition that
     * contains the specified element of the universal set.
     * Implements "collapsing find".
     *
     * @param integer $item The element of the universal set to find.
     * @return object ISet The element of this parition that
     * contains the specified element of the universal set.
     */
    public function findItem($item)
    {
        $root = $this->array[$item];
        while ($root->getParent() !== NULL)
            $root = $root->getParent();
        $ptr = $this->array[$item];
        while ($ptr->getParent() !== NULL)
        {
            $tmp = $ptr->getParent();
            $ptr->setParent($root);
            $ptr = $tmp;
        }
        return $root;
    }
//}>a

//{
    /**
     * Joins the specified elements of this partition.
     * Implements "union-by-size".
     *
     * @param object ISet $p An element of this parition.
     * @param object ISet $q An element of this parition.
     */
    public function join(ISet $p, ISet $q)
    {
        $this->checkArguments($p, $q);
        if ($p->getCount() > $q->getCount())
        {
            $q->setParent($p);
            $p->setCount($p->getCount() + $q->getCount());
        }
        else
        {
            $p->setParent($q);
            $q->setCount($p->getCount () + $q->getCount());
        }
        --$this->count;
    }
//}>b

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("PartitionAsForestV2 main program.\n");
        $status = 0;
        $p = new PartitionAsForestV2(5);
        AbstractPartition::test($p);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(PartitionAsForestV2::main(array_slice($argv, 1)));
}
?>
