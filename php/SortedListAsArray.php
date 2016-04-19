<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: SortedListAsArray.php,v 1.5 2005/12/09 01:11:17 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/OrderedListAsArray.php';
require_once 'Opus11/ISortedList.php';
require_once 'Opus11/AbstractSortedList.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * Represents a position in a SortedListAsArray.
 *
 * @package Opus11
 */
class SortedListAsArray_Cursor
    extends OrderedListAsArray_Cursor
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a SortedListAsArray_Cursor
     * with the given list and offset.
     *
     * @param object SortedListAsArray $list A list.
     */
    public function __construct(
        SortedListAsArray $list, $offset = 0)
    {
        parent::__construct($list, $offset);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Inserts the specified object in the sorted list
     * after this position.
     * @param object IObject $obj The object to insert.
     */
    public function insertAfter(IObject $obj)
    {
        throw new IllegalOperationException();
    }

    /**
     * Inserts the specified object in the sorted list
     * before this position.
     * @param object IObject $obj The object to insert.
     */
    public function insertBefore(IObject $obj)
    {
        throw new IllegalOperationException();
    }
//}>g
}

//{
/**
 * Represents an sorted list implemented using an array.
 *
 * @package Opus11
 */
class SortedListAsArray
    extends OrderedListAsArray
    implements ISortedList
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a SortedListAsArray with the given size.
     *
     * @param integer $size The size of this list.
     */
    public function __construct($size = 0)
    {
        parent::__construct($size);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }
//}>a

//{
    /**
     * Inserts the specified object into this sorted list.
     * @param object IComparable $obj The object to insert.
     */
    public function insert(IComparable $obj)
    {
        if ($this->count == $this->array->getLength())
            throw new ContainerFullException();
        $i = $this->count;
        while ($i > 0 && gt($this->array[$i - 1], $obj))
        {
            $this->array[$i] = $this->array[$i - 1];
            --$i;
        }
        $this->array[$i] = $obj;
        ++$this->count;
    }
//}>b

//{
    /**
     * Finds the offset in this sorted list of the object
     * that matches the given object.
     *
     * @param object IComparable $obj An object.
     * @return integer The offset of the matching object;
     * -1 if no match is found.
     */
    public function findOffset(IComparable $obj)
    {
        $left = 0;
        $right = $this->count - 1;
        while ($left <= $right)
        {
            $middle = intval(($left + $right) / 2);
            if (gt($obj, $this->array[$middle]))
                $left = $middle + 1;
            elseif (lt($obj, $this->array[$middle]))
                $right = $middle - 1;
            else
                return $middle;
        }
        return -1;
    }
//}>c

//{
    /**
     * Finds an object in this sorted list that matches the specified object.
     * @param object IComparable $arg The object to match.
     * @return object IComparable
     * The object in this list that matches the specified object;
     * NULL if no match is found.
     */
    public function find(IComparable $obj)
    {
        $offset = $this->findOffset($obj);
        if ($offset >= 0)
            return $this->array[$offset];
        else
            return NULL;
    }
//}>d

//{
    /**
     * Withdraws the given object from this sorted list.
     *
     * @param object IComparable $obj The object to be withdrawn.
     */
    public function withdraw(IComparable $obj)
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        $offset = $this->findOffset($obj);
        if ($offset < 0)
            throw new ArgumentError();
        for ($i = $offset; $i < $this->count - 1; ++$i)
            $this->array[$i] = $this->array[$i + 1];
        $this->array[$i] = NULL;
        $this->count -= 1;
    }
//}>e

//{
    /**
     * Returns the position of an object in this sorted list
     * that matches the specified object.
     *
     * @param object IComparable $obj The object to match.
     * @return object Cursor The position in this list of the matching object.
     */
    public function findPosition(IComparable $obj)
    {
        return new SortedListAsArray_Cursor(
            $this, $this->findOffset($obj));
    }
//}>f

    /**
     * Returns an iterator that enumerates the objects in this list.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new SortedListAsArray_Cursor($this);
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("SortedListAsArray main program.\n");
        $status = 0;
        $list = new SortedListAsArray(5);
        AbstractSortedList::test($list);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(SortedListAsArray::main(array_slice($argv, 1)));
}
?>
