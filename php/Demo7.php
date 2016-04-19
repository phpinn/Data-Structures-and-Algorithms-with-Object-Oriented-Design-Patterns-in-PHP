<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Demo7.php,v 1.8 2005/12/09 01:11:10 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/SetAsArray.php';
require_once 'Opus11/SetAsBitVector.php';
require_once 'Opus11/MultisetAsArray.php';
require_once 'Opus11/MultisetAsLinkedList.php';
require_once 'Opus11/PartitionAsForest.php';

/**
 * Provides demonstration program number 7.
 *
 * @package Opus11
 */
class Demo7
{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on succes; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Demonstration program number 7.\n");
        $status = 0;
        SetAsArray::main($args);
        SetAsBitVector::main($args);
        MultisetAsArray::main($args);
        MultisetAsLinkedList::main($args);
        PartitionAsForest::main($args);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Demo7::main(array_slice($argv, 1)));
}
?>
