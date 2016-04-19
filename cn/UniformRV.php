<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: UniformRV.php,v 1.3 2005/12/09 01:11:18 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractRandomVariable.php';
require_once 'Opus11/RandomNumberGenerator.php';

//{
/**
 * A random variable uniformly distributed on a specified interval, (u,v].
 *
 * @package Opus11
 */
class UniformRV
    extends AbstractRandomVariable
{
    /**
     * @var float The lower bound of the distribution.
     */
    protected $u = 0.0;
    /**
     * @var float The upper bound of the distribution.
     */
    protected $v = 1.0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a UniformRV.
     *
     * @param float $u The lower bound.
     * @param float $v The upper bound.
     */
    public function __construct($u = 0.0, $v = 1.0)
    {
        parent::__construct();
        $this->u = $u;
        $this->v = $v;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Returns the next random sample.
     *
     * @return float The next sample.
     */
    public function next()
    {
        return $this->u + ($this->v - $this->u) *
            RandomNumberGenerator::next();
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
        printf("UniformRV main program.\n");
        $status = 0;
        $rv = new UniformRV(0.0, 100.0);
        AbstractRandomVariable::test($rv);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(UniformRV::main(array_slice($argv, 1)));
}
?>
