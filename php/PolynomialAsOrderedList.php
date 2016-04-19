<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: PolynomialAsOrderedList.php,v 1.4 2005/12/09 01:11:15 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IPolynomial.php';
require_once 'Opus11/OrderedListAsLinkedList.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * A polynomial implemented using an ordered list.
 *
 * @package Opus11
 */
class PolynomialAsOrderedList
    implements IPolynomial
{
    /**
     * var object OrderedList List of the terms in this polynomial.
     */
    protected $list = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a PolynomialAsOrderedList.
     * The polynomial initially contains no terms.
     * I.e., it is the zero polynomial.
     */
    public function __construct()
    {
        $this->list = new OrderedListAsLinkedList();
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
//}>a

    /**
     * Returns a textual representation of this polynomial.
     *
     * @return string A string.
     */
    public function __toString()
    {
        return str($this->list);
    }

    /**
     * Returns the sum of this polynomial and the specified polynomial.
     * This method is not implemented.
     *
     * @param object IPolynomial $poly
     * The polynomial to be added to this polynomial.
     * @return object IPolynomial
     * The sum of this polynomial and the specified polynomial.
     */
    public function plus(IPolynomial $poly)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("PolynomialAsOrderedList main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(PolynomialAsOrderedList::main(array_slice($argv, 1)));
}
?>
