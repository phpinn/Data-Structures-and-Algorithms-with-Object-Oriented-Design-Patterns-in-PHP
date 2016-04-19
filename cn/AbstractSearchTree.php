<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractSearchTree.php,v 1.5 2005/12/09 01:11:04 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractTree.php';
require_once 'Opus11/ISearchTree.php';

//{
/**
 * Abstract base class from which all search tree classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractSearchTree
    extends AbstractTree
    implements ISearchTree
{
//!    // ...
//!}
//}>a

    /**
     * Constructor.
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

    /**
     * Search tree test program.
     *
     * @param object ISearchTree $tree The tree to test.
     */
    public static function test(ISearchTree $tree)
    {
        printf("AbstractSearchTree test program.\n");
        printf("%s\n", str($tree));
        for ($i = 1; $i <= 8; ++$i)
        {
            $tree->insert(box($i));
        }
        printf("%s\n", str($tree));

        printf("Breadth-First traversal\n");
        $tree->breadthFirstTraversal(
            new PrintingVisitor(STDOUT));

        printf("Preorder traversal\n");
        $tree->depthFirstTraversal(new PreOrder(
            new PrintingVisitor(STDOUT)));

        printf("Inorder traversal\n");
        $tree->depthFirstTraversal(new InOrder(
            new PrintingVisitor(STDOUT)));

        printf("Postorder traversal\n");
        $tree->depthFirstTraversal(new PostOrder(
            new PrintingVisitor(STDOUT)));

        printf("Using foreach\n");
        foreach ($tree as $obj)
        {
            printf("%s\n", str($obj));
        }

        printf("Using reduce\n");
        $tree->reduce(create_function(
            '$sum,$obj', 'printf("%s\n", str($obj));'), '');

        printf("Using accept\n");
        $tree->accept(new ReducingVisitor(create_function(
            '$sum,$obj', 'printf("%s\n", str($obj));'), ''));

        printf("Withdrawing 4\n");
        $obj = $tree->find(box(4));
        try
        {
            $tree->withdraw($obj);
            printf("%s\n", str($tree));
        }
        catch (Exception $e)
        {
            printf("Caught %s\n", $e->getMessage());
        }
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractSearchTree main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractSearchTree::main(array_slice($argv, 1)));
}
?>
