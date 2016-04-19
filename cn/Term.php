<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Term.php,v 1.3 2005/12/09 01:11:18 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractComparable.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * A term in a polynomial.
 *
 * @package Opus11
 */
class Term
    extends AbstractComparable
{
    /**
     * @var float The coefficient of this term.
     */
    protected $coefficient = 0.0;
    /**
     * @var integer The exponent of this term.
     */
    protected $exponent = 0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a Term with the specified coefficient and exponent.
     *
     * @param float $coefficient The desired coefficient.
     * @param integer $exponent The desired exponent.
     */
    public function __construct($coefficient, $exponent)
    {
        parent::__construct();
        $this->coefficient = $coefficient;
        $this->exponent = $exponent;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }
//}>a

    /**
     * Compares this term with the specified comparable object.
     * The specified comparable object is assumed to be a Term instance.
     * If the exponents of the terms differ,
     * then the term with the smaller exponent
     * is less than the term with the larger coefficient.
     * If the exponents are equal but the coefficients differ,
     * then the term with the smaller coefficient
     * is less than the term with the larger coefficient.
     * Otherwise, the terms are considered to be equal.
     *
     * @param object IComparable $obj
     * The object with which this term is compared.
     * @return integer A number less than zero if this term is less than
     * the specified term;
     * a number greater than zero if this term is greater than
     * the specified term;
     * zero if the two terms are equal.
     */
    protected function compareTo(IComparable $obj)
    {
        if ($this->exponent == $obj->exponent)
        {
            if ($this->coefficient < $obj->coefficient)
                return -1;
            elseif ($this->coefficient > $obj->coefficient)
                return +1;
            else
                return 0;
        }
        else
            return $this->exponent - $obj->exponent;
    }

    /**
     * Differentiates this term.
     */
    public function differentiate()
    {
        if ($this->exponent > 0)
        {
            $this->coefficient *= $this->exponent;
            $this->exponent -= 1;
        }
        else
            $this->coefficient = 0;
    }
//}>a

//{
    /**
     * Returns a clone of this term.
     *
     * @return object Term A Term.
     */
    public function __clone()
    {
        return new Term($this->coefficient, $this->exponent);
    }

    /**
     * Coefficient getter.
     *
     * @return float The coefficient of this term.
     */
    public function getCoefficient ()
    {
        return $this->coefficient;
    }

    /**
     * Exponent getter.
     *
     * @return integer The exponent of this term.
     */
    public function getExponent()
    {
        return $this->exponent;
    }

    /**
     * Returns a term that is the sum of this term
     * and the specified term.
     *
     * @param object Term $arg The term to be added to this term.
     * @return object Term The sum of this term and the specified term.
     */
    public function plus(Term $arg)
    {
        if ($this->exponent != $arg->exponent)
            throw new ArgumentError ();
        return new Term (
            $this->coefficient + $arg->coefficient,
            $this->exponent);
    }
//}>b

    /**
     * Returns a textual representation of this term.
     *
     * @return string A string.
     */
    public function __toString()
    {
        return str($this->coefficient) . 'x^' . str($this->exponent);
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Term main program.\n");
        $status = 0;
        $term1 = new Term(1.5, 10);
        $term2 = new Term(2.5, 10);
        $term3 = $term1->plus($term2);
        printf("%s\n", str($term1));
        printf("%s\n", str($term2));
        printf("%s\n", str($term3));
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Term::main(array_slice($argv, 1)));
}
?>
