<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Application7.php,v 1.6 2005/12/09 01:11:06 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Algorithms.php';

/**
 * Provides application program number 7.
 *
 * @package Opus11
 */
class Application7
{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Application program number 7. (translator)\n");
        $status = 0;
        $dictionary = fopen('dict.txt', 'r');
        Algorithms::translate($dictionary, STDIN, STDOUT);
        fclose($dictionary);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Application7::main(array_slice($argv, 1)));
}
?>
