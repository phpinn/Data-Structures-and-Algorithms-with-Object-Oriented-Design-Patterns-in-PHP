<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: SetAsBitVector.php,v 1.4 2005/12/09 01:11:16 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSet.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/Exceptions.php';
require_once 'Opus11/Limits.php';

//{
/**
 * Set implemented using a vector of integers.
 *
 * @package Opus11
 */
class SetAsBitVector
    extends AbstractSet
{
    /**
     * The array of bits.
     */
    protected $vector = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a SetAsBitVector for the specified size
     * of universal set.
     *
     * @param integer $n The number of elements in the universal set.
     */
    public function __construct($n = 0)
    {
        parent::__construct($n);
        $this->vector  = new BasicArray(
            intval(($n + Limits::INTBITS - 1)/ Limits::INTBITS));
        for ($i = 0; $i < $this->vector->getLength(); ++$i)
            $this->vector[$i] = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->vector = NULL;
        parent::__destruct();
    }
//}>a

//{
    /**
     * Inserts the specified item into this set.
     *
     * @param integer $item The item to insert.
     */
    public function insertItem($item)
    {
        $this->vector[intval($item / Limits::INTBITS)] |=
            1 << $item % Limits::INTBITS;
    }

    /**
     * Withdraws the specified item from this set.
     *
     * @param integer $item The item to be withdrawn.
     */
    public function withdrawItem($item)
    {
        $this->vector[intval($item / Limits::INTBITS)] &=
            ~(1 << $item % Limits::INTBITS);
    }

    /**
     * Tests if the specified item is a member of this set.
     *
     * @param integer $item The item for which to look.
     * @return boolean True if the item is a member of this set;
     * false otherwise.
     */
    public function containsItem($item)
    {
        return ($this->vector[intval($item / Limits::INTBITS)] &
            (1 << $item % Limits::INTBITS)) != 0;
    }
//}>b

    /**
     * Purges this set, making it empty.
     */
    public function purge()
    {
        for ($i = 0; $i < $this->vector->getLength(); ++$i)
            $this->vector[$i] = 0;
    }

//{
    /**
     * Returns a set which is the union of this set
     * and the specified set.
     * It is assumed that the specified set is an instance of
     * the SetAsBitVector class.
     *
     * @param object ISet $set The set to join with this set.
     * @return object SetAsBitVector
     * The union of this set with the specified set.
     */
    public function union(ISet $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        $result = new SetAsBitVector($this->universeSize);
        for ($i = 0; $i < $this->vector->getLength(); ++$i)
            $result->vector[$i] =
                $this->vector[$i] | $set->vector[$i];
        return $result;
    }

    /**
     * Returns a set which is the intersection of this set
     * and the specified set.
     * It is assumed that the specified set is an instance of
     * the SetAsBitVector class.
     *
     * @param object ISet $set The set to intersect with this set.
     * @return object SetAsBitVector
     * The intersection of this set with the specified set.
     */
    public function intersection(ISet $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        $result = new SetAsBitVector($this->universeSize);
        for ($i = 0; $i < $this->vector->getLength(); ++$i)
            $result->vector[$i] =
                $this->vector[$i] & $set->vector[$i];
        return $result;
    }

    /**
     * Returns a set which is the difference between this set
     * and the specified set.
     * It is assumed that the specified set is an instance of
     * the SetAsBitVector class.
     *
     * @param object ISet $set The set to subtract from this set.
     * @return object SetAsBitVector
     * The difference between this set and the specified set.
     */
    public function difference(ISet $set)
    {
        if ($this->getClass() != $set->getClass())
            throw new TypeError();
        if ($this->universeSize != $set->universeSize)
            throw new ArgumentError();
        $result = new SetAsBitVector($this->universeSize);
        for ($i = 0; $i < $this->vector->getLength(); ++$i)
            $result->vector[$i] =
                $this->vector[$i] & ~$set->vector[$i];
        return $result;
    }
//}>c

    /**
     * Tests whether this set is a subset of the specified set.
     * It is assumed that the specified set is an instance of
     * the <code>SetAsBitVector</code> class.
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
        for ($i = 0; $i < $this->vector->length(); ++$i)
            if (($this->vector[$i] & ~$set->vector[$i]) != 0)
                return false;
        return true;
    }

    /**
     * Tests whether this set is equal to the specified set.
     * It is assumed that the specified set is an instance of
     * the <code>SetAsBitVector</code> class.
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
        for ($i = 0; $i < $this->vector->getLength(); ++$i)
            if ($this->vector[$i] != $set->vector[$i])
                return false;
        return true;
    }

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
        printf("SetAsBitVector main program.\n");
        $status = 0;
        $s1 = new SetAsBitVector(57);
        $s2 = new SetAsBitVector(57);
        $s3 = new SetAsBitVector(57);
        AbstractSet::test($s1, $s2, $s3);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(SetAsBitVector::main(array_slice($argv, 1)));
}
?>
