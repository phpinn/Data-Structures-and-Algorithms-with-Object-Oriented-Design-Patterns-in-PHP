<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractCursor.php,v 1.6 2005/12/09 01:11:02 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractIterator.php';
require_once 'Opus11/ICursor.php';

//{
/**
 * Abstract base class from which all cursor classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractCursor
    extends AbstractIterator
    implements ICursor
{

//!    // ...
//!}
//}>a

    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractCursor main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractCursor::main(array_slice($argv, 1)));
}
?>
