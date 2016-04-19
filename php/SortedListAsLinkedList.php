<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: SortedListAsLinkedList.php,v 1.5 2005/12/09 01:11:17 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/OrderedListAsLinkedList.php';
require_once 'Opus11/ISortedList.php';
require_once 'Opus11/AbstractSortedList.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * Represents a position in a SortedListAsLinkedList.
 *
 * @package Opus11
 */
class SortedListAsLinkedList_Cursor
    extends OrderedListAsLinkedList_Cursor
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a SortedListAsLinkedList_Cursor
     * with the given list and offset.
     *
     * @param object SortedListAsLinkedList $list A list.
     * @param object LinkedList_Element $element A linked list element.
     * @param mixed $key A key.
     */
    public function __construct(
        SortedListAsLinkedList $list, $element = NULL, $key = 0)
    {
        parent::__construct($list, $element, $key);
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
//}>d
}

//{
/**
 * Represents an sorted list implemented using an array.
 *
 * @package Opus11
 */
class SortedListAsLinkedList
    extends OrderedListAsLinkedList
    implements ISortedList
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a SortedListAsLinkedList with the given size.
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
        $prevPtr = NULL;
        for ($ptr = $this->list->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            if (ge($ptr->getDatum(), $obj))
                break;
            $prevPtr = $ptr;
        }
        if ($prevPtr === NULL)
            $this->list->prepend($obj);
        else
            $prevPtr->insertAfter($obj);
        ++$this->count;
    }
//}>b

//{
    public function findElement($obj)
    {
        for ($ptr = $this->list->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            if (ge($ptr->getDatum(), $obj))
                return $ptr;
        }
        return NULL;
    }

    /**
     * Returns the position of an object in this sorted list
     * that matches the specified object.
     *
     * @param object IComparable $obj The object to match.
     * @return object Cursor The position in this list of the matching object.
     */
    public function findPosition(IComparable $obj)
    {
        return new SortedListAsLinkedList_Cursor(
            $this, $this->findElement($obj));
    }
//}>c

    /**
     * Returns an iterator that enumerates the objects in this list.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new SortedListAsLinkedList_Cursor(
            $this, $this->list->getHead(), 0);
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("SortedListAsLinkedList main program.\n");
        $status = 0;
        $list = new SortedListAsLinkedList(5);
        AbstractSortedList::test($list);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(SortedListAsLinkedList::main(array_slice($argv, 1)));
}
?>
