<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IContainer.php,v 1.8 2005/11/27 23:32:31 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IComparable.php';
require_once 'Opus11/IVisitor.php';

//{
/**
 * Interface implemented by all containers.
 *
 * @package Opus11
 */
interface IContainer
    extends IComparable, IteratorAggregate
{
    /**
     * Count getter.
     *
     * @return integer The number of items in this container.
     */
    public abstract function getCount();
    /**
     * IsEmpty predicate.
     *
     * @return boolean True if this container is empty.
     */
    public abstract function isEmpty();
    /**
     * IsFull predicate.
     *
     * @return boolean True if this container is full.
     */
    public abstract function isFull();
    /**
     * Purges this container.
     */
    public abstract function purge();
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
     * @param mixed $initialState The initial value.
     * @return mixed The value returned by
     * the last call to the callback function.
     */
    public abstract function reduce($callback, $initialState);
    /**
     * Calls the visit method of the given visitor
     * for each item in this container.
     *
     * @param object IVisitor $visitor A visitor.
     */
    public abstract function accept(IVisitor $visitor);
}
//}>a
?>
