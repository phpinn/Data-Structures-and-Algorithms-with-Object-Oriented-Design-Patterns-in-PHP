<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractIterator.php,v 1.6 2005/12/09 01:11:03 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IIterator.php';

//{
/**
 * Abstract base class from which all iterator classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractIterator
    implements IIterator
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
     * Returns the next object to be enumerated by this iterator.
     * Returns NULL when there are no more objects.
     *
     * @return mixed The next object to be enumerated.
     */
    public function succ()
    {
        $result = NULL;
        if ($this->valid())
        {
            $result = $this->current();
            $this->next();
        }
        return $result;
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractIterator main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractIterator::main(array_slice($argv, 1)));
}
?>
