<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractSortedList.php,v 1.5 2005/12/09 01:11:05 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSearchableContainer.php';
require_once 'Opus11/ISortedList.php';
require_once 'Opus11/Box.php';

//{
/**
 * Abstract base class from which all sorted list classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractSortedList
    extends AbstractSearchableContainer
    implements ISortedList
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
     * SortedList test method.
     *
     * @param object ISortedList $list The list to test.
     */
    public static function test(ISortedList $list)
    {
        printf("AbstractSortedList test program.\n");

        $list->insert(box(4));
        $list->insert(box(3));
        $list->insert(box(2));
        $list->insert(box(1));
        printf("%s\n", str($list));
        $obj = $list->find(box(2));
        $list->withdraw($obj);
        printf("%s\n", str($list));

        printf("Using foreach\n");
        foreach ($list as $obj)
        {
            printf("%s\n", str($obj));
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
        printf("AbstractSortedList main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractSortedList::main(array_slice($argv, 1)));
}
?>
