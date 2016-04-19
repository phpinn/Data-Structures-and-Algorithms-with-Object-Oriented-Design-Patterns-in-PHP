<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Exceptions.php,v 1.8 2005/12/09 01:11:11 brpreiss Exp $
 * @package Opus11
 */

/**
 * Argument error exception.
 *
 * @package Opus11
 */
class ArgumentError
    extends Exception
{
    /**
     * Constructs an ArgumentError.
     */
    public function __construct()
    {
        parent::__construct(__CLASS__);
    }
}

/**
 * Container empty exception.
 *
 * @package Opus11
 */
class ContainerEmptyException
    extends Exception
{
    /**
     * Constructs a ContainerEmptyException.
     */
    public function __construct()
    {
        parent::__construct(__CLASS__);
    }
}

/**
 * Container full exception.
 *
 * @package Opus11
 */
class ContainerFullException
    extends Exception
{
    /**
     * Constructs a ContainerFullException.
     */
    public function __construct()
    {
        parent::__construct(__CLASS__);
    }
}

/**
 * Index error exception.
 *
 * @package Opus11
 */
class IndexError
    extends Exception
{
    /**
     * Constructs an IndexError.
     */
    public function __construct()
    {
        parent::__construct(__CLASS__);
    }
}

/**
 * Method not implemented exception.
 *
 * @package Opus11
 */
class MethodNotImplementedException
    extends Exception
{
    /**
     * Constructs an MethodNotImplementedException.
     */
    public function __construct()
    {
        parent::__construct(__CLASS__);
    }
}

/**
 * Type error exception.
 *
 * @package Opus11
 */
class TypeError
    extends Exception
{
    /**
     * Constructs an ArgumentError.
     */
    public function __construct()
    {
        parent::__construct(__CLASS__);
    }
}

/**
 * State error exception.
 *
 * @package Opus11
 */
class StateError
    extends Exception
{
    /**
     * Constructs an ArgumentError.
     */
    public function __construct()
    {
        parent::__construct(__CLASS__);
    }
}

/**
 * Illegal operation exception.
 *
 * @package Opus11
 */
class IllegalOperationException
    extends Exception
{
    /**
     * Constructs an IllegalOperationException.
     */
    public function __construct()
    {
        parent::__construct(__CLASS__);
    }
}
?>
