<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: SimpleRV.php,v 1.3 2005/12/09 01:11:16 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractRandomVariable.php';
require_once 'Opus11/RandomNumberGenerator.php';

//{
/**
 * A random variable uniformly distributed on the unit interval (0,1].
 *
 * @package Opus11
 */
class SimpleRV
    extends AbstractRandomVariable
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a SimpleRV.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     *
     */
    public function next()
    {
        return RandomNumberGenerator::next();
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
        printf("SimpleRV main program.\n");
        $status = 0;
        $rv = new SimpleRV();
        AbstractRandomVariable::test($rv);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(SimpleRV::main(array_slice($argv, 1)));
}
?>
