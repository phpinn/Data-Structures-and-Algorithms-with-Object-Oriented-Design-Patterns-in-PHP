<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractContainer.php,v 1.14 2005/12/09 01:11:02 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractComparable.php';
require_once 'Opus11/IContainer.php';

//{
/**
 * Abstract base class from which all container classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractContainer
    extends AbstractComparable
    implements IContainer
{
    /**
     * @var integer The number of items in this container.
     */
    protected $count;

//}@head

//{
//!    // ...
//!}
//}@tail

    /**
     * Constructs an AbstractContainer.
     */
    public function __construct()
    {
        parent::__construct();
        $count = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Purge method.
     */
    public function purge()
    {
        $this->count = 0;
    }

//{
    /**
     * Count getter.
     *
     * @return integer The number of items in this container.
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * IsEmpty predicate.
     *
     * @return boolean True if this container is empty.
     */
    public function isEmpty()
    {
        return $this->getCount() == 0;
    }

    /**
     * IsFull predicate.
     *
     * @return boolean True if this container is full.
     */
    public function isFull()
    {
        return false;
    }
//}>a

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
        foreach ($this as $obj)
        {
            $state = $callback($state, $obj);
        }
        return $state;
    }

    /**
     * Calls the visit method of the given visitor
     * for each object in this container.
     *
     * @param object IVisitor $visitor A visitor.
     */
    public function accept(IVisitor $visitor)
    {
        foreach ($this as $obj)
        {
            if ($visitor->isDone())
                break;
            $visitor->visit($obj);
        }
    }

//{
    /**
     * Returns a textual representation of this container.
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
        return $this->getClass()->getName() .  '{' . $s[0] . '}';
    }
//}>b
    
//{
    /**
     * Returns a hash code for this container.
     *
     * @return integer A hash code. 
     */
    public function getHashCode()
    {
        $s = $this->reduce(
            create_function(
                '$s, $obj',
                'return $s + $obj->getHashCode();'
            ), 0);
        return $s;
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
        printf("AbstractContainer main program.\n");
        $status = 0;
        return $status;
    }

}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractContainer::main(array_slice($argv, 1)));
}
?>
