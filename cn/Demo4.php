<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Demo4.php,v 1.6 2005/12/09 01:11:09 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/ChainedHashTable.php';
require_once 'Opus11/ChainedScatterTable.php';
require_once 'Opus11/OpenScatterTable.php';
require_once 'Opus11/OpenScatterTableV2.php';

/**
 * Provides demonstration program number 4.
 *
 * @package Opus11
 */
class Demo4
{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on succes; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Demonstration program number 4.\n");
        $status = 0;
        ChainedHashTable::main($args);
        ChainedScatterTable::main($args);
        OpenScatterTable::main($args);
        OpenScatterTableV2::main($args);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Demo4::main(array_slice($argv, 1)));
}
?>
