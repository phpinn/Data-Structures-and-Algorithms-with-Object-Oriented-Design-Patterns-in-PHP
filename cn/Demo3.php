<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Demo3.php,v 1.10 2005/12/09 01:11:09 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/OrderedListAsArray.php';
require_once 'Opus11/OrderedListAsLinkedList.php';
require_once 'Opus11/SortedListAsArray.php';
require_once 'Opus11/SortedListAsLinkedList.php';

/**
 * Provides demonstration program number 3.
 *
 * @package Opus11
 */
class Demo3
{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on succes; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Demonstration program number 3.\n");
        $status = 0;
        OrderedListAsArray::main($args);
        OrderedListAsLinkedList::main($args);
        SortedListAsArray::main($args);
        SortedListAsLinkedList::main($args);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Demo3::main(array_slice($argv, 1)));
}
?>
