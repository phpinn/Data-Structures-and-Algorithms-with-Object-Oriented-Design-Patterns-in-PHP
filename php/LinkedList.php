<?php
/**
 * @copyright Copyright &copy; 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: LinkedList.php,v 1.13 2005/12/09 01:11:13 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractObject.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * Represents an element of a linked list.
 *
 * @package Opus11
 */
class LinkedList_Element
{
    /**
     * @var object LinkedList The linked list to which this element belongs.
     */
    protected $list = NULL;
    /**
     * @var mixed The datum in this element.
     */
    protected $datum = NULL;
    /**
     * @var object LinkedList_Element The next list element.
     */
    protected $next = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a LinkedList_Element with the given values.
     *
     * @param mixed $list A linked list.
     * @param mixed $datum An item.
     * @param mixed $next The next element.
     */
    public function __construct($list, $datum, $next)
    {
        $this->list = $list;
        $this->datum = $datum;
        $this->next = $next;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
    }

    /**
     * List getter.
     * 
     * @return object LinkedList The list of this element.
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * Datum getter.
     *
     * @return mixed The datum of this element.
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * Next getter.
     *
     * @return mixed The next element of this element.
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * Next setter.
     *
     * @param object LinkedList_Element $next The new next element.
     */
    public function setNext(LinkedList_Element $next)
    {
        if ($this->list !== $next->list)
            throw new ArgumentError();
        $this->next = $next;
    }

    /**
     * Next unsetter.
     */
    public function unsetNext()
    {
        $this->next = NULL;
    }
//}>a

//{
    /**
     * Inserts the given item in the linked list after this element.
     *
     * @param mixed $item The item to insert.
     */
    public function insertAfter($item)
    {
        $this->next = new LinkedList_Element(
            $this->list, $item, $this->next);
        if ($this->list->getTail() === $this)
            $this->list->setTail($this->next);
    }

    /**
     * Inserts the given item in the linked list before this element.
     *
     * @param mixed $item The item to insert.
     */
    public function insertBefore($item)
    {
        $tmp = new LinkedList_Element($this->list, $item, $this);
        if ($this === $this->list->getHead())
        {
            if ($tmp === NULL)
                $list->unsetHead();
            else
                $list->setHead($tmp);
        }
        else
        {
            $prevPtr = $this->list->getHead();
            while ($prevPtr !== NULL && $prevPtr->next != $this)
                $prevPtr = $prevPtr->next;
            $prevPtr->next = $tmp;
        }
    }
//}>j

    /**
     * Extracts this list element from the linked list.
     */
    public function extract()
    {
        $prevPtr = NULL;
        if ($this->list->getHead() === $this)
        {
            if ($this->next === NULL)
                $list->unsetHead();
            else
                $list->setHead($this->next);
        }
        else
        {
            $prevPtr = $this->list->getHead();
            while ($prevPtr !== NULL && $prevPtr->next != $this)
                $prevPtr = $prevPtr->next;
            if (prevPtr === NULL)
                throw new ArgumentError();
            $prevPtr->next = $this->next;
        }
        if ($this->list->getTail() === $this)
        {
            if ($prevPtr === NULL)
                $list->unsetTail();
            else
                $list->setTail($prevPtr);
        }
    }
}

//{
/**
 * Represents a linked list.
 *
 * @package Opus11
 */
class LinkedList
    extends AbstractObject
{
    /**
     * @var object LinkedList_Element
     * The element at the head of the linked list.
     */
    protected $head = NULL;
    /**
     * @var object LinkedList_Element
     * The element at the tail of the linked list.
     */
    protected $tail = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a LinkedList.
     */
    public function __construct()
    {
        parent::__construct();
        $this->head = NULL;
        $this->tail = NULL;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->head = NULL;
        $this->tail = NULL;
        parent::__destruct();
    }
//}>b

//{
    /**
     * Purges this linked list.
     */
    public function purge()
    {
        $this->head = NULL;
        $this->tail = NULL;
    }
//}>c

//{
    /**
     * Head getter.
     *
     * @return mixed The head element of this linked list.
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Head setter.
     *
     * @param object LinkedList_Element $element An element.
     */
    public function setHead(LinkedList_Element $element)
    {
        if ($element->getList() !== $this)
            throw new ArgumentError();
        $this->head = $element;
    }

    /**
     * Head unsetter.
     */
    public function unsetHead()
    {
        $this->head = NULL;
    }

    /**
     * Tail getter.
     *
     * @return mixed The tail element of this linked list.
     */
    public function getTail()
    {
        return $this->tail;
    }

    /**
     * Tail setter.
     *
     * @param object LinkedList_Element $element An element.
     */
    public function setTail(LinkedList_Element $element)
    {
        if ($element->getList() !== $this)
            throw new ArgumentError();
        $this->tail = $element;
    }

    /**
     * Tail unsetter.
     */
    public function unsetTail()
    {
        $this->tail = NULL;
    }

    /**
     * IsEmpty predicate.
     *
     * @return boolean True if this linked list is empty.
     */
    public function isEmpty()
    {
        return $this->head === NULL;
    }
//}>d

//{
    /**
     * First getter.
     *
     * @return mixed The first item in this linked list.
     */
    public function getFirst()
    {
        if ($this->head === NULL)
            throw new ContainerEmptyException();
        return $this->head->getDatum();
    }

    /**
     * Last getter.
     *
     * @return mixed The last item in this linked list.
     */
    public function getLast()
    {
        if ($this->tail === NULL)
            throw new ContainerEmptyException();
        return $this->tail->getDatum();
    }
//}>e
    
//{
    /**
     * Prepends the given item to this linked list.
     *
     * @param mixed $item The item to prepend.
     */
    public function prepend($item)
    {
        $tmp = new LinkedList_Element($this, $item, $this->head);
        if ($this->head === NULL)
            $this->tail = $tmp;
        $this->head = $tmp;
    }
//}f

//{
    /**
     * Appends the given item to this linked list.
     *
     * @param mixed $item The item to append.
     */
    public function append($item)
    {
        $tmp = new LinkedList_Element($this, $item, NULL);
        if ($this->head === NULL)
            $this->head = $tmp;
        else
            $this->tail->setNext($tmp);
        $this->tail = $tmp;
    }
//}>g

//{
    /**
     * Returns a clone of this linked list.
     *
     * @return object LinkedList A LinkedList.
     */
    public function __clone()
    {
        $result = new LinkedList();
        for ($ptr = $this->head;
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            $result->append($ptr->getDatum());
        }
        return $result;
    }
//}>h

//{
    /**
     * Extracts an item that equals the given item from this linked list.
     *
     * @param mixed $item The item to extract.
     */
    public function extract($item)
    {
        $ptr = $this->head;
        $prevPtr = NULL;
        while ($ptr !== NULL && $ptr->getDatum() !== $item)
        {
            $prevPtr = $ptr;
            $ptr = $ptr->getNext();
        }
        if ($ptr === NULL)
            throw new ArgumentError();
        if ($ptr === $this->head)
            $this->head = $ptr->getNext();
        else
        {
            $tmp = $ptr->getNext();
            if ($tmp === NULL)
                $prevPtr->unsetNext();
            else
                $prevPtr->setNext($ptr->getNext());
        }
        if ($ptr === $this->tail)
            $this->tail = $prevPtr;
    }
//}>i

    /**
     * Returns a value computed by calling the given callback function
     * for each item in this container.
     * Each time the callback function will be called with two arguments:
     * The first argument is the next item in this container.
     * The first time the callback function is called,
     * the second argument is the given initial value.
     * On subsequent calls to the callback function,
     * the second argument is the result returned from
     * the previous call to the callback function.
     *
     * @param callback $callback A callback function.
     * @param mixed $initialState The initial state.
     * @return mixed The value returned by
     * the last call to the callback function.
     */
    public function reduce($callback, $initialState)
    {
        $state = $initialState;
        $ptr = $this->head;
        while ($ptr !== NULL)
        {
            $state = $callback($state, $ptr->getDatum());
            $ptr = $ptr->getNext();
        }
        return $state;
    }

    /**
     * Returns a textual representation of this linked list.
     *
     * @return string A string.
     */
    public function __toString()
    {
        $s = $this->reduce(
            create_function(
                '$s, $item', 
                'return array($s[0] . $s[1] . str($item), ", ");'
            ), array('',''));
        return 'LinkedList{' . $s[0] . '}';
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("LinkedList main program.\n");
        $status = 0;
        $l1 = new LinkedList();
        $l1->append(57);
        $l1->append('hello');
        $l1->append(NULL);
        printf("%s\n", str($l1));
        printf("isEmpty returns %s\n", str($l1->isEmpty()));
        printf("Using reduce\n");
        $l1->reduce(
            create_function('$sum, $item',
                'printf("%s\n", str($item));'), '');
        printf("Purging\n");
        $l1->purge();
        printf("%s\n", str($l1));
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(LinkedList::main(array_slice($argv, 1)));
}
?>
