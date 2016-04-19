<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: StackAsArray.php,v 1.12 2005/12/09 01:11:17 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractStack.php';
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * An iterator that enumerates the items in a StackAsArray.
 *
 * @package Opus11
 */
class StackAsArray_Iterator
    extends AbstractIterator
{
    /**
     * @var object StackAsArray The stack to enumerate.
     */
    protected $stack = NULL;
    /**
     * @var integer The current position.
     */
    protected $position = 0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a StackAsArray_Iterator for the given stack.
     *
     * @param object StackAsArray $stack A stack.
     */
    public function __construct(StackAsArray $stack)
    {
        parent::__construct();
        $this->stack = $stack;
        $this->position = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->stack = NULL;
        parent::__destruct();
    }

    /**
     * Valid predicate.
     *
     * @return boolean True if the current position of this iterator is valid.
     */
    public function valid()
        { return $this->position < $this->stack->getCount(); }

    /**
     * Key getter.
     *
     * @return integer The key for the current position of this iterator.
     */
    public function key()
        { return $this->position; }

    /**
     * Current getter.
     *
     * @return mixed The value for the current postion of this iterator.
     */
    public function current()
    {
        $array = $this->stack->getArray();
        return $array[$this->position];
    }

    /**
     * Advances this iterator to the next position.
     */
    public function next()
        { $this->position += 1; }

    /**
     * Rewinds this iterator to the first position.
     */
    public function rewind()
        { $this->position = 0; }
//}>f
}

//{
/**
 * Represents a stack implemented using an array.
 *
 * @package Opus11
 */
class StackAsArray
    extends AbstractStack
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
     * Constructs a StackAsArray with the given size.
     *
     * @param integer $size The size of this stack.
     */
    public function __construct($size = 0)
    {
        parent::__construct();
        $this->array = new BasicArray($size);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->array = NULL;
        parent::__destruct();
    }

    /**
     * Array getter.
     *
     * @return object BasicArray A reference to the array of this stack.
     */
    public function & getArray()
    {
        return $this->array;
    }
//}>a

//{
    /**
     * Purges this stack.
     */
    public function purge()
    {
        while ($this->count > 0)
        {
            $this->count -= 1;
            $this->array[$this->count] = NULL;
        }
    }
//}>b

//{
    /**
     * Pushes the given object onto this stack.
     *
     * @param object IObject $obj The object to push.
     */
    public function push(IObject $obj)
    {
        if ($this->count == $this->array->getLength())
            throw new ContainerFullException();
        $this->array[$this->count] = $obj;
        $this->count += 1;
    }

    /**
     * Pops and returns the top object on this stack.
     *
     * @return object IObject The top object on this stack.
     */
    public function pop()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        $this->count -= 1;
        $result = $this->array[$this->count];
        $this->array[$this->count] = NULL;
        return $result;
    }

    /**
     * Top getter.
     *
     * @return object IObject The top object on this stack.
     */
    public function getTop()
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        return $this->array[$this->count - 1];
    }
//}>c

//{
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
        for ($i = 0; $i < $this->count; ++$i)
        {
            $state = $callback($state, $this->array[$i]);
        }
        return $state;
    }
//}>d

//{
    /**
     * Returns an iterator that enumerates the objects in this stack.
     *
     * @return object Iterator An iterator.
     */
    public function getIterator()
    {
        return new StackAsArray_Iterator($this);
    }
//}>e

    /**
     * IsFull predicate.
     *
     * @return boolean True if this stack is full.
     */
    public function isFull()
    {
        return $this->count == $this->array->getLength();
    }

    /**
     * Compares this object with the given object.
     * This object and the given object are instances of the same class.
     *
     * @param object IComparable $obj The given object.
     * @return integer A number less than zero
     * if this object is less than the given object,
     * zero if this object equals the given object, and
     * a number greater than zero
     * if this object is greater than the given object.
     */
    public function compareTo(IComparable $obj)
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
        printf("StackAsArray main program.\n");
        $status = 0;
        $stack = new StackAsArray(5);
        AbstractStack::test($stack);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(StackAsArray::main(array_slice($argv, 1)));
}
?>
