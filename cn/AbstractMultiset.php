<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractMultiset.php,v 1.7 2005/12/09 01:11:03 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSearchableContainer.php';
require_once 'Opus11/IMultiset.php';
require_once 'BoxedInteger.php';
require_once 'Exceptions.php';

//{
/**
 * Abstract base class from which all multiset classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractMultiset
    extends AbstractSearchableContainer
    implements IMultiset
{
    /**
     * @var integer The size of the universal set.
     */
    protected $universeSize = 0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs an AbstractMultiset with the given universe size.
     *
     * @param integer $universeSize The size of the universal set.
     */
    public function __construct($universeSize)
    {
        parent::__construct();
        $this->universeSize = $universeSize;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * UniverseSize getter.
     *
     * @return integer The size of the universal set.
     */
    public function getUniverseSize()
    {
        return $this->universeSize;
    }
//}>a

//{
    /**
     * Inserts the given object into this set.
     *
     * @param object IComparable $obj The object to insert.
     */
    public function insert(IComparable $obj)
    {
        $this->insertItem(unbox($obj));
    }

    /**
     * Withdraws the given object from this set.
     *
     * @param object IComparable $obj The object to withdraw.
     */
    public function withdraw(IComparable $obj)
    {
        $this->withdrawItem(unbox($obj));
    }

    /**
     * Contains predicate.
     *
     * @return boolean True if this set contains the given object.
     */
    public function contains(IComparable $obj)
    {
        return $this->containsItem(unbox($obj));
    }

    /**
     * Returns the given object if is contained in this set; otherwise NULL.
     * 
     * @return mixed The given object or NULL.
     */
    public function find(IComparable $obj)
    {
        if ($this->containsItem(unbox($obj)))
            return $obj;
        else
            return NULL;
    }
//}>b

    /**
     * Multiset test method.
     *
     * @param object IMultiset $s1 A set to test.
     * @param object IMultiset $s2 A set to test.
     * @param object IMultiset $s3 A set to test.
     */
    public static function test(IMultiset $s1, IMultiset $s2, IMultiset $s3)
    {
        printf("AbstractMultiset test program.\n");

        for ($i = 0; $i < 4; ++$i)
        {
            $s1->insert(box($i));
        }
        for ($i = 2; $i < 6; ++$i)
        {
            $s2->insert(box($i));
        }
        $s3->insert(box(0));
        $s3->insert(box(2));
        printf("%s\n", str($s1));
        printf("%s\n", str($s2));
        printf("%s\n", str($s3));
        printf("%s\n", str($s1->union($s2))); # union
        printf("%s\n", str($s1->intersection($s3))); # intersection
        printf("%s\n", str($s1->difference($s3))); # difference

        printf("Using foreach\n");
        foreach ($s3 as $obj)
        {
            printf("%s\n", str($obj));
        }

        printf("Using reduce\n");
        $s3->reduce(create_function(
            '$sum,$obj', 'printf("%s\n", str($obj));'), '');
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractMultiset main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractMultiset::main(array_slice($argv, 1)));
}
?>
