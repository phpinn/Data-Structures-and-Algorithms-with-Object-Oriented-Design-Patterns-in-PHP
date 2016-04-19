<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractSearchableContainer.php,v 1.8 2005/12/09 01:11:04 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractContainer.php';
require_once 'Opus11/ISearchableContainer.php';

//{
/**
 * Abstract base class from which all searchable container classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractSearchableContainer
    extends AbstractContainer
    implements ISearchableContainer
{

//!    // ...
//!}
//}>a

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
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractSearchableContainer main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractSearchableContainer::main(array_slice($argv, 1)));
}
?>
