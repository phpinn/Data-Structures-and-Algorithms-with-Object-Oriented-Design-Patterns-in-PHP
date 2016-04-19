<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Application3.php,v 1.6 2005/12/09 01:11:06 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/PolynomialAsOrderedList.php';
require_once 'Opus11/PolynomialAsSortedList.php';

/**
 * Provides application program number 3.
 *
 * @package Opus11
 */
class Application3
{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Application program number 3.\n");
        $status = 0;

        $p1 = new PolynomialAsOrderedList();
        $p1->add(new Term(4.5, 5));
        $p1->add(new Term(3.2, 14));
        printf("%s\n", str($p1));
        $p1->differentiate();
        printf("%s\n", str($p1));

        $p2 = new PolynomialAsSortedList();
        $p2->add(new Term(7.8, 0));
        $p2->add(new Term(1.6, 14));
        $p2->add(new Term(9.999, 27));
        printf("%s\n", str($p2));
        $p2->differentiate();
        printf("%s\n", str($p2));

        $p3 = new PolynomialAsSortedList();
        $p3->add(new Term(0.6, 13));
        $p3->add(new Term(-269.973, 26));
        $p3->add(new Term(1000, 1000));
        printf("%s\n", str($p3));
        printf("%s\n", str($p2->plus($p3)));

        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Application3::main(array_slice($argv, 1)));
}
?>
