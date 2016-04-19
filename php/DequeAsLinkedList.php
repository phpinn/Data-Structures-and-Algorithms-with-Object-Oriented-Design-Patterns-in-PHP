<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: DequeAsLinkedList.php,v 1.7 2005/12/09 01:11:10 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/QueueAsLinkedList.php';
require_once 'Opus11/AbstractDeque.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * Represents a deque implemented using a linked list.
 *
 * @package Opus11
 */
class DequeAsLinkedList
    extends QueueAsLinkedList
    implements IDeque
{
//}@head

//{
//!    // ...
//!}
//}@tail

    /**
     * Constructs a DequeAsLinkedList.
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

//{
    /**
     * Enqueues the given object at the head of this deque.
     *
     * @param object IObject $obj The object to enqueue.
     */
    public function enqueueHead(IObject $obj)
    {
        $this->list->prepend($obj);
        $this->count += 1;
    }

    /**
     * Dequeues and returns the object at the head of this deque.
     *
     * @return object IObject The object at the head of this deque.
     */
    public function dequeueHead()
    {
        return $this->dequeue();
    }
//}>b

//{
    /**
     * Enqueues the given object at the tail of this deque.
     *
     * @param object IObject $obj The object to enqueue.
     */
    public function enqueueTail(IObject $obj)
    {
        $this->enqueue($obj);
    }

    /**
     * Dequeues and returns the object at the tail of this deque.
     *
     * @return object IObject The object at the tail of this deque.
     */
    public function dequeueTail()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        $result = $this->list->getLast();
        $this->list->extract($result);
        $this->count -= 1;
        return $result;
    }

    /**
     * Tail getter.
     *
     * @return object IObject The object at the tail of this deque.
     */
    public function getTail()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        return $this->list->getLast();
    }
//}>c

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("DequeAsLinkedList main program.\n");
        $status = 0;
        $deque = new DequeAsLinkedList();
        AbstractDeque::test($deque);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(DequeAsLinkedList::main(array_slice($argv, 1)));
}
?>
