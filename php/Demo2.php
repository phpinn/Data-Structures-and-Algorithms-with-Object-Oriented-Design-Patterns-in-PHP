<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Demo2.php,v 1.11 2005/12/09 01:11:09 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/StackAsArray.php';
require_once 'Opus11/StackAsLinkedList.php';
require_once 'Opus11/QueueAsArray.php';
require_once 'Opus11/QueueAsLinkedList.php';
require_once 'Opus11/DequeAsArray.php';
require_once 'Opus11/DequeAsLinkedList.php';

/**
 * Provides demonstration program number 2.
 *
 * @package Opus11
 */
class Demo2
{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on succes; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Demonstration program number 2.\n");
        $status = 0;
        StackAsArray::main($args);
        StackAsLinkedList::main($args);
        QueueAsArray::main($args);
        QueueAsLinkedList::main($args);
        DequeAsArray::main($args);
        DequeAsLinkedList::main($args);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Demo2::main(array_slice($argv, 1)));
}
?>
