<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: SetAsArray.php,v 1.4 2005/12/09 01:11:16 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSet.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * Set implemented using an array of booleans.
 *
 * @package Opus11
 */
class SetAsArray
    extends AbstractSet
{
    /**
     * @var object BasicArray The array.
     */
    protected $array = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a SetAsArray for the specified size
     * of universal set.
     *
     * @param integer n The number of elements in the universal set.
     */
    public function __construct($n = 0)
    {
        parent::__construct($n);
        $this->array = new BasicArray($n);
        for ($item = 0; $item < $this->universeSize; ++$item)
            $this->array[$item] = false;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->array = NULL;
        parent::__destruct();
    }
//}>a

//{
    /**
     * Inserts the specified item into this set.
     *
     * @param integer item The item to insert.
     */
    public function insertItem($item)
    {
        $this->array[$item] = true;
    }

    /**
     * Tests if the specified item is a member of this set.
     *
     * @param integer item The item for which to look.
     * @return boolean True if the item is a member of this set;
     * false otherwise.
     */
    public function containsItem($item)
    {
        return $this->array[$item];
    }

    /**
     * Withdraws the specified item from this set.
     *
     * @param integer item The item to be withdrawn.
     */
    public function withdrawItem($item)
    {
        $this->array[$item] = false;
    }
//}>b

    /**
     * Purges this set, making it empty.
     */
    public function purge()
    {
        for ($item = 0; $item < $this->universeSize; ++$item)
            $this->array[$item] = false;
    }

//{
    /**
     * Returns a set which is the union of this set
     * and the specified set.
     * It is assumed that the specified set is an instance of
     * the SetAsArray class.
     *
     * @param object ISet $set The set to join with this set.
     * @return object SetAsArray The union of this set with the specified set.
     */
    public function union(ISet $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        $result = new SetAsArray($this->universeSize);
        for ($i = 0; $i < $this->universeSize; ++$i)
            $result->array[$i] =
                $this->array[$i] || $set->array[$i];
        return $result;
    }

    /**
     * Returns a set which is the intersection of this set
     * and the specified set.
     * It is assumed that the specified set is an instance of
     * the <code>SetAsArray</code> class.
     *
     * @param object ISet $set The set to intersect with this set.
     * @return object SetAsArray
     * The intersection of this set with the specified set.
     */
    public function intersection(ISet $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        $result = new SetAsArray($this->universeSize);
        for ($i = 0; $i < $this->universeSize; ++$i)
            $result->array[$i] =
                $this->array[$i] && $set->array[$i];
        return $result;
    }

    /**
     * Returns a set which is the difference between this set
     * and the specified set.
     * It is assumed that the specified set is an instance of
     * the SetAsArray class.
     *
     * @param object ISet $set The set to subtract from this set.
     * @return object SetAsArray
     * The difference between this set and the specified set.
     */
    public function difference(ISet $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        $result = new SetAsArray($this->universeSize);
        for ($i = 0; $i < $this->universeSize; ++$i)
            $result->array[$i] =
                $this->array[$i] && !$set->array[$i];
        return $result;
    }
//}>c

//{
    /**
     * Tests whether this set is equal to the specified set.
     * It is assumed that the specified set is an instance of
     * the SetAsArray class.
     *
     * @param object ISet $set The set to compare with this set.
     * @return boolean True if the sets are equal; false otherwise.
     */
    public function eq(IComparable $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        for ($item = 0; $item < $this->universeSize; ++$item)
            if ($this->array[$item] != $set->array[$item])
                return false;
        return true;
    }

    /**
     * Tests whether this set is a subset of the specified set.
     * It is assumed that the specified set is an instance of
     * the SetAsArray class.
     *
     * @param object ISet $set The set to compare with this set.
     * @return boolean True if the this set is a subset of the specified set;
     * false otherwise.
     */
    public function isSubset(ISet $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        for ($item = 0; $item < $this->universeSize; ++$item)
            if ($this->array[$item] && !$set->array[$item])
                return false;
        return true;
    }
//}>d

    /**
     * Compares this set with the specified comparable object.
     * This method is not implemented.
     *
     * @param object IComparable $arg
     * The comparable object to compare with this set.
     */
    protected function compareTo(IComparable $arg)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("SetAsArray main program.\n");
        $status = 0;
        $s1 = new SetAsArray(57);
        $s2 = new SetAsArray(57);
        $s3 = new SetAsArray(57);
        AbstractSet::test($s1, $s2, $s3);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(SetAsArray::main(array_slice($argv, 1)));
}
?>
