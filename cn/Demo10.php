<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Demo10.php,v 1.2 2005/12/09 01:11:09 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/GraphAsMatrix.php';
require_once 'Opus11/GraphAsLists.php';
require_once 'Opus11/DigraphAsMatrix.php';
require_once 'Opus11/DigraphAsLists.php';

/**
 * Provides demonstration program number 10.
 *
 * @package Opus11
 */
class Demo10
{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on succes; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Demonstration program number 10.\n");
        $status = 0;
        GraphAsMatrix::main($args);
        GraphAsLists::main($args);
        DigraphAsMatrix::main($args);
        DigraphAsLists::main($args);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Demo10::main(array_slice($argv, 1)));
}
?>
