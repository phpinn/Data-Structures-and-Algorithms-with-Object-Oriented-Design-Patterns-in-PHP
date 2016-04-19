<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Demo5.php,v 1.10 2005/12/09 01:11:09 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/GeneralTree.php';
require_once 'Opus11/BinaryTree.php';
require_once 'Opus11/NaryTree.php';
require_once 'Opus11/BinarySearchTree.php';
require_once 'Opus11/AVLTree.php';
require_once 'Opus11/MWayTree.php';
require_once 'Opus11/BTree.php';

/**
 * Provides demonstration program number 5.
 *
 * @package Opus11
 */
class Demo5
{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on succes; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Demonstration program number 5.\n");
        $status = 0;
        GeneralTree::main($args);
        BinaryTree::main($args);
        NaryTree::main($args);
        BinarySearchTree::main($args);
        AVLTree::main($args);
        MWayTree::main($args);
        BTree::main($args);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Demo5::main(array_slice($argv, 1)));
}
?>
