<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ExponentialRV.php,v 1.4 2005/12/09 01:11:11 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractRandomVariable.php';
require_once 'Opus11/RandomNumberGenerator.php';

//{
/**
 * An exponentially distributed random variable with mean mu.
 *
 * @package Opus11
 */
class ExponentialRV
    extends AbstractRandomVariable
{
    /**
     * The mean.
     */
    protected $mu = 1.0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs an ExponentialRV.
     */
    public function __construct($mu = 1.0)
    {
        parent::__construct();
        $this->mu = $mu;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Returns the next random number.
     *
     * @return float The next random number.
     */
    public function next()
    {
        return -$this->mu *
            log(RandomNumberGenerator::next());
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
        printf("ExponentialRV main program.\n");
        $status = 0;
        $rv = new ExponentialRV(100.0);
        AbstractRandomVariable::test($rv);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(ExponentialRV::main(array_slice($argv, 1)));
}
?>
