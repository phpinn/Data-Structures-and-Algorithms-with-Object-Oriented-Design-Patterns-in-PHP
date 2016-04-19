<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractRandomVariable.php,v 1.5 2005/12/09 01:11:04 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractObject.php';
require_once 'Opus11/IRandomVariable.php';

/**
 * Abstract base class from which all random variable classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractRandomVariable
    extends AbstractObject
    implements IRandomVariable
{

    /**
     * Constructor.
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
     * RandomVariable test method.
     *
     * @param object IRandomVariable $rv The random variable to test.
     */
    public static function test(IRandomVariable $rv)
    {
        printf("AbstractRandomVariable test program.\n");

        for ($i = 0; $i < 10; ++$i)
        {
            printf("%.15f\n", $rv->next());
        }
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractRandomVariable main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractRandomVariable::main(array_slice($argv, 1)));
}
?>
