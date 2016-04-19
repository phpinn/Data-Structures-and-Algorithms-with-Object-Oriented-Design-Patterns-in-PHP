<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: BinomialTree.php,v 1.5 2005/12/09 01:11:07 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/GeneralTree.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * A node in a binomial tree.
 *
 * @package Opus11
 */
class BinomialTree
    extends GeneralTree
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a BinomialTree of order zero
     * that containst the specified key.
     *
     * @param integer $size The size of this queue.
     */
    public function __construct(IObject $key)
    {
        parent::__construct($key);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Count getter.
     *
     * @return integer The number of objects contained in this binomial tree.
     */
    public function getCount()
    {
        return 1 << $this->degree;
    }

    /**
     * Swaps the contents of this binomial tree node
     * with those of the specified binomial tree node.
     *
     * @param object BinomialTree $tree
     * The node with which to swap the contents of this node.
     */
    public function swapContentsWith(BinomialTree $tree)
    {
        list($this->key, $tree->key) =
            array($tree->key, $this->key);
        list($this->list, $tree->list) =
            array($tree->list, $this->list);
        list($this->degree, $tree->degree) =
            array($tree->degree, $this->degree);
    }

//{
    /**
    * Adds the specified binomial tree to this binomial tree.
    * The specified binomial tree and this binomial tree
    * must have the same order.
    * @param object BinomialTree $tree
    * The binomial tree to add to this binomial tree.
    * @exception IllegalArgumentException
    * If the orders of the trees differ.
    **/
    public function add(BinomialTree $tree)
    {
        if ($this->degree != $tree->degree)
            throw new ArgumentError();
        if (gt($this->key, $tree->key))
            $this->swapContentsWith($tree);
        $this->attachSubtree($tree);
        return $this;
    }
//}>a

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("BinomialTree main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(BinomialTree::main(array_slice($argv, 1)));
}
?>
