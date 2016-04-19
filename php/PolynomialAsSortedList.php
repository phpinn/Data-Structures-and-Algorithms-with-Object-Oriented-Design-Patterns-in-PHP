<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: PolynomialAsSortedList.php,v 1.3 2005/12/09 01:11:15 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IPolynomial.php';
require_once 'Opus11/SortedListAsLinkedList.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * A polynomial implemented using a sorted list.
 *
 * @package Opus11
 */
class PolynomialAsSortedList
    implements IPolynomial
{
    /**
     * @var object SortedList List of the terms in this polynomial.
     */
    protected $list = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

    /**
     * Constructs a PolynomialAsSortedList.
     * The polynomial initially contains no terms.
     * I.e., it is the zero polynomial.
     */
    public function __construct()
    {
        $this->list = new SortedListAsLinkedList();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->list = NULL;
    }

    /**
     * Adds the specified term to this polynomial.
     *
     * @param object Term $term The term to be added to this polynomial.
     */
    public function add(Term $term)
    {
        $this->list->insert($term);
    }

    /**
     * Differentiates this polynomial.
     * Implemented using a visitor that differentiates one-by-one
     * all the terms in this polynomial.
     */
    public function differentiate()
    {
        $this->list->reduce(
            create_function(
                '$skip, $term',
                '$term->differentiate();'),
            NULL
        );
        $zeroTerm = $this->list->find(new Term (0, 0));
        if ($zeroTerm !== NULL)
            $this->list->withdraw($zeroTerm);
    }

    /**
     * Returns a textual representation of this polynomial.
     *
     * @return string A string.
     */
    public function __toString()
    {
        return str($this->list);
    }

//{
    /**
     * Returns the sum of this polynomial and the specified polynomial.
     * This method is not implemented.
     *
     * @param object IPolynomial $poly
     * The polynomial to be added to this polynomial.
     * @return object IPolynomial
     * $he sum of this polynomial and the specified polynomial.
     */
    public function plus(IPolynomial $poly)
    {
        $result = new PolynomialAsSortedList();
        $p1 = $this->list->getIterator();
        $p2 = $poly->list->getIterator();
        $term1 = NULL;
        $term2 = NULL;
        while ($p1->valid() && $p2->valid()) {
            if ($term1 === NULL) $term1 = $p1->succ();
            if ($term2 === NULL) $term2 = $p2->succ();
            if ($term1->getExponent() < $term2->getExponent()) {
                $result->add(clone($term1));
                $term1 = NULL;
            }
            elseif($term1->getExponent()>$term2->getExponent()) {
                $result->add(clone($term2));
                $term2 = NULL;
            }
            else {
                $sum = $term1->plus($term2);
                if ($sum->getCoefficient() != 0)
                    $result->add($sum);
                $term1 = NULL;
                $term2 = NULL;
            }
        }
        while ($term1 !== NULL || $p1->valid()) {
            if ($term1 === NULL) $term1 = $p1->succ();
            $result->add(clone($term1)); $term1 = NULL;
        }
        while ($term2 !== NULL || $p2->valid()) {
            if ($term2 === NULL) $term2 = $p2->succ();
            $result->add(clone($term2)); $term2 = NULL;
        }
        return $result;
    }
//}>a

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("PolynomialAsSortedList main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(PolynomialAsSortedList::main(array_slice($argv, 1)));
}
?>
