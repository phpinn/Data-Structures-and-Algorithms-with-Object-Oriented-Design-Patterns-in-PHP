<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractHashTable.php,v 1.6 2005/12/09 01:11:03 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSearchableContainer.php';
require_once 'Opus11/IHashTable.php';
require_once 'Opus11/Association.php';
require_once 'Opus11/Box.php';

//{
/**
 * Abstract base class from which all hash table classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractHashTable
    extends AbstractSearchableContainer
    implements IHashTable
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
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
     * Length getter.
     *
     * @return integer The length of this hash table.
     */
    public abstract function getLength();

    /**
     * Returns the hashcode for the specified object.
     *
     * @param object IObject $obj The object to be hashed.
     * @return integer The hash code.
     */
    protected function f(IObject $obj)
    {
        return $obj->getHashCode();
    }

    /**
     * Hashes an integer using the division method of hashing.
     *
     * @param integer $x The integer to be hashed.
     * @return integer A positive integer in the interval [0,getLenght()-1].
     */
    protected function g($x)
    {
        return abs($x) % $this->getLength();
    }

    /**
     * Hashes the given object using the compositions of methods f and g.
     *
     * @param object IObject $obj The object to be hashed.
     * @return integer A positive integer in the interval [0,getLenght()-1].
     */
    protected function h(IObject $obj)
    {
        return $this->g($this->f($obj));
    }
//}>a

//{
    /**
     * LoadFactor getter.
     *
     * @return float The current load factor of this hash table.
     */
    public function getLoadFactor()
    {
        return (double)$this->getCount() /
            (double)$this->getLength();
    }
//}>b

    /**
     * HashTable test method.
     *
     * @param object IHashTable $hashTable The hash table to test.
     */
    public static function test(IHashTable $hashTable)
    {
        printf("AbstractHashTable test program.\n");
        printf("%s\n", str($hashTable));
        $hashTable->insert(new Association(box("foo"), box(12)));
        $hashTable->insert(new Association(box("bar"), box(34)));
        $hashTable->insert(new Association(box("foo"), box(56)));
        printf("%s\n", str($hashTable));
        $obj = $hashTable->find(new Association(box("foo")));
        printf("%s\n", str($obj));
        $hashTable->withdraw($obj);
        printf("%s\n", str($hashTable));

        printf("Using foreach\n");
        foreach ($hashTable as $obj)
        {
            printf("%s\n", str($obj));
        }

        printf("Using reduce\n");
        $hashTable->reduce(create_function(
            '$sum,$obj', 'printf("%s\n", str($obj));'), '');

        $hashTable->purge();
        printf("%s\n", str($hashTable));
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractHashTable main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractHashTable::main(array_slice($argv, 1)));
}
?>
