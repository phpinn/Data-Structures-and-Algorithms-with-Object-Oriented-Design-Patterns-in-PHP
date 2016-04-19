<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Application4.php,v 1.5 2005/12/09 01:11:06 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/PolynomialAsSortedList.php';

/**
 * Provides application program number 4.
 *
 * @package Opus11
 */
class Application4
{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Application program number 4.\n");
        $status = 0;

        $p1 = new PolynomialAsSortedList();
        $p1->add(new Term(4.5, 5));
        $p1->add(new Term(3.2, 14));
        printf("%s\n", str($p1));

        $p2 = new PolynomialAsSortedList();
        $p2->add(new Term(7.8, 3));
        $p2->add(new Term(1.6, 14));
        $p2->add(new Term(9.999, 27));
        printf("%s\n", str($p2));

        $p3 = $p1->plus($p2);
        printf("%s\n", str($p3));

        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Application4::main(array_slice($argv, 1)));
}
?>
