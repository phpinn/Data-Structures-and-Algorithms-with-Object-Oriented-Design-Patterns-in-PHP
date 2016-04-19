<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IPolynomial.php,v 1.3 2005/11/27 23:32:32 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Term.php';

//{
/**
 * Interface implemented by all polynomials.
 *
 * @package Opus11
 */
interface IPolynomial
{
    /**
     * Adds the specified term to this polynomial.
     *
     * @param object Term $term The term to be added to this polynomial.
     */
    public abstract function add(Term $term);
    /**
     * Differentiates this polynomial.
     * The terms of this polynomial are each differentiated one-by-one.
    .*/
    public abstract function differentiate();
    /**
     * Returns the sum of this polynomial and the specified polynomial.
     *
     * @param object IPolynomial $polynomial
     * The polynomial to add to this polynomial.
     * @return object IPolynomial
     * The sum of this polynomial and the specified polynomial.
     */
    public abstract function plus(IPolynomial $polynomial);
}
//}>a
?>
