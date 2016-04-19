<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: DequeAsArray.php,v 1.7 2005/12/09 01:11:10 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/QueueAsArray.php';
require_once 'Opus11/AbstractDeque.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * Represents a deque implemented using an array.
 *
 * @package Opus11
 */
class DequeAsArray
    extends QueueAsArray
    implements IDeque
{
//}@head

//{
//!    // ...
//!}
//}@tail

    /**
     * Constructs a DequeAsArray with the given size.
     *
     * @param integer $size The size of this deque.
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

//{
    /**
     * Enqueues the given object at the head of this deque.
     *
     * @param object IObject $obj The object to enqueue.
     */
    public function enqueueHead(IObject $obj)
    {
        if ($this->count == $this->array->getLength())
            throw new ContainerFullException();
        if (--$this->head < 0)
            $this->head = $this->array->getLength() - 1;
        $this->array[$this->head] = $obj;
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
//}>a

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
        $result = $this->array[$this->tail];
        $this->array[$this->tail] = NULL;
        if (--$this->tail < 0)
            $this->tail = $this->array->getLength() - 1;
        $this->count -= 1;
        return $result;
    }

    /**
     * Tail getter.
     *
     * @return object IOBject The object at the tail of this deque.
     */
    public function getTail()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        return $this->array[$this->tail];
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
        printf("DequeAsArray main program.\n");
        $status = 0;
        $deque = new DequeAsArray(10);
        AbstractDeque::test($deque);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(DequeAsArray::main(array_slice($argv, 1)));
}
?>
