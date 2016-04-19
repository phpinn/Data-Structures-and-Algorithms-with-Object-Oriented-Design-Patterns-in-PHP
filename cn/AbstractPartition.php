<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractPartition.php,v 1.2 2005/12/09 01:11:03 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSet.php';
require_once 'Opus11/IPartition.php';
require_once 'BoxedInteger.php';
require_once 'Exceptions.php';

//{
/**
 * Abstract base class from which all partition classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractPartition
    extends AbstractSet
    implements IPartition
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs an AbstractPartition with the given universe size.
     *
     * @param integer $universeSize The size of the universal set.
     */
    public function __construct($universeSize)
    {
        parent::__construct($universeSize);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Set test method.
     *
     * @param object IPartition $p A partition to test.
     */
    public static function test(IPartition $p)
    {
        printf("AbstractPartition test program.\n");
        printf("%s\n", str($p));
        $s2 = $p->findItem(2);
        printf("%s\n", str($s2));
        $s4 = $p->findItem(4);
        printf("%s\n", str($s4));
        $p->join($s2, $s4);
        printf("%s\n", str($p));
        $s3 = $p->findItem(3);
        printf("%s\n", str($s3));
        $s4b = $p->findItem(4);
        printf("%s\n", str($s4b));
        $p->join($s3, $s4b);
        printf("%s\n", str($p));
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractPartition main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractPartition::main(array_slice($argv, 1)));
}
?>
