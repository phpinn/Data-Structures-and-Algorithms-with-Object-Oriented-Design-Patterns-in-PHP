<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Complex.php,v 1.2 2005/12/09 01:11:09 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IObject.php';

//{
/**
 * A complex number.
 *
 * @package Opus11
 */
class Complex
{
    /**
     * @var float The real part of this complex number.
     */
    protected $real = 0.0;
    /**
     * @var float The imaginary part of this complex number.
     */
    protected $imag = 0.0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Sets the real part of this complex number to the specified value.
     *
     * @param float $real The desired real value.
     */
    public function setReal($real)
    {
        $this->real = $real;
    }

    /**
    * Sets the imaginary part of this complex number to the specified value.
    *
    * @param float $imag The desired imaginary value.
    **/
    public function setImag($imag)
    {
        $this->imag = $imag;
    }
//}>a

//{
    /**
     * Constructs a Complex with the specified real and imaginary parts.
     *
     * @param float $real The desired real value.
     * @param float $imag The desired imaginary value.
     */
    public function __construct($real = 0.0, $imag = 0.0)
    {
        $this->real = $real;
        $this->imag = $imag;
    }
//}>b

//{
    /**
     * Returns the real part of this complex number.
     *
     * @return float The real part of this complex number.
     */
    public function getReal()
    {
        return $this->real;
    }

    /**
     * Returns the imaginary part of this complex number.
     *
     * @return float The imaginary part of this complex number.
     */
    public function getImag()
    {
        return $this->imag;
    }

    /**
     * Returns the magnitude of this complex number.
     *
     * @return float The magnitude of this complex number.
     */
    public function getR()
    {
        return sqrt(
            $this->real * $this->real +
            $this->imag * $this->imag);
    }

    /**
     * Returns the angle of this complex number.
     *
     * @return float The angle of this complex number.
     */
    public function getTheta()
    {
        return atan2($this->imag, $this->real);
    }

    /**
     * Returns a string representation of this complex number.
     *
     * @return string A string representation of this complex number.
     */
    public function __toString()
    {
        return str($this->real) . '+' . str($this->imag) . 'i';
    }
//}>c

//{
    /**
     * Sets the magnitude of this complex number to the specified value.
     *
     * @param float $r The desired magnitude.
     */
    public function setR($r)
    {
        $theta = $this->getTheta();
        $this->real = $r * cos($theta);
        $this->imag = $r * sin($theta);
    }

    /**
     * Sets the angle of this complex number to the specified value.
     *
     * @param float $theta The desired angle.
     */
    public function setTheta($theta)
    {
        $r = $this->getR();
        $this->real = $r * cos($theta);
        $this->imag = $r * sin($theta);
    }

    /**
     * Assigns the value of the specified complex number
     * to this complex number.
     *
     * @param object Complex $c The desired complex value.
     */
    public function assign(Complex $c)
    {
        $this->real = $c->real;
        $this->imag = $c->imag;
    }
//}>d

//{
    /**
     * Returns the sum of this complex number
     * and the given complex number.
     *
     * @param object Complex $c The given complex number.
     * @return object Complex The sum.
     */
    public function plus(Complex $c)
    {
        return new Complex(
            $this->getReal() + $c->getReal(),
            $this->getImag() + $c->getImag());
    }

    /**
     * Returns the difference of this complex number
     * and the given complex number.
     *
     * @param object Complex $c The given complex number.
     * @return object Complex The difference.
     */
    public function minus(Complex $c)
    {
        return new Complex(
            $this->getReal() - $c->getReal(),
            $this->getImag() - $c->getImag());
    }

    /**
     * Returns the negative of this complex number.
     *
     * @return object Complex The negation.
     */
    public function neg()
    {
        return new Complex(
            -$this->getReal(),
            -$this->getImag());
    }
//}>e

//{
    /**
     * Returns the product of this complex number
     * and the given complex number.
     *
     * @param object Complex $c The given complex number.
     * @return object Complex The product.
     */
    public function times(Complex $c)
    {
        return new Complex(
            $this->getReal() * $c->getReal() -
            $this->getImag() * $c->getImag(),
            $this->getReal() * $c->getImag() +
            $this->getImag() * $c->getReal());
    }

    /**
     * Returns the quotient of this complex number
     * and the given complex number.
     *
     * @param object Complex $c The given complex number.
     * @return object Complex The quotient.
     */
    public function div(Complex $c)
    {
        $denom = $c->getReal() * $c->getReal() -
            $c->getImag() * $c->getImag();
        return new Complex(
            ($this->getReal() * $c->getReal() -
                $this->getImag() * $c->getImag()) / $denom,
            ($this->getImag() * $c->getReal() -
                $this->getReal() * $c->getImag()) / $denom);
    }

//}>f

//{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
//[
        printf("Complex main program.\n");
//]
        $status = 0;
        $c = new Complex(0, 0);
        printf("%s\n", str($c));
        $c->setReal(1);
        $c->setImag(2);
        printf("%s\n", str($c));
        $c->setTheta(M_PI/2);
        $c->setR(50);
        printf("%s\n", str($c));
        $c = new Complex(1, 2);
        $d = new Complex(3, 4);
        printf("%s\n", str($c));
        printf("%s\n", str($d));
        printf("%s\n", str($c->plus($d)));
        printf("%s\n", str($c->minus($d)));
        printf("%s\n", str($c->times($d)));
        printf("%s\n", str($c->div($d)));
        printf("%s\n", str($c->neg()));
        return $status;
    }
//}>g
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Complex::main(array_slice($argv, 1)));
}
?>
