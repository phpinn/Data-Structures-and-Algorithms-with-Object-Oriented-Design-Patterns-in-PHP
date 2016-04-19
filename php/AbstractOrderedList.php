<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractOrderedList.php,v 1.8 2005/12/09 01:11:03 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractSearchableContainer.php';
require_once 'Opus11/IOrderedList.php';
require_once 'Opus11/Box.php';

//{
/**
 * Abstract base class from which all ordered list classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractOrderedList
    extends AbstractSearchableContainer
    implements IOrderedList
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
     * OrderedList test method.
     *
     * @param object IOrderedList $list The list to test.
     */
    public static function test(IOrderedList $list)
    {
        printf("AbstractOrderedList test program.\n");

        $list->insert(box(1));
        $list->insert(box(2));
        $list->insert(box(3));
        $list->insert(box(4));
        printf("%s\n", str($list));
        $obj = $list->find(box(2));
        $list->withdraw($obj);
        printf("%s\n", str($list));
        $position = $list->findPosition(box(3));
        $position->insertAfter(box(5));
        printf("%s\n", str($list));
        $position->insertBefore(box(6));
        printf("%s\n", str($list));
        $position->withdraw();
        printf("%s\n", str($list));

        printf("Using foreach\n");
        foreach ($list as $obj)
        {
            printf("%s\n", str($obj));
        }

        printf("Using reduce\n");
        $list->reduce(create_function(
            '$sum,$obj', 'printf("%s\n", str($obj));'), '');
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractOrderedList main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractOrderedList::main(array_slice($argv, 1)));
}
?>
