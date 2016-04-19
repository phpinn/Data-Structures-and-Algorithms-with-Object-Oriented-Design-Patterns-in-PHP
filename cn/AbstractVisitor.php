<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractVisitor.php,v 1.5 2005/12/09 01:11:05 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IVisitor.php';

//{
/**
 * Abstract base class from which all visitor classes are derived..
 *
 * @package Opus11
 */
abstract class AbstractVisitor
    implements IVisitor
{
    /**
     * Constructs this AbstractVisitor.
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
     * IsDone predicate.
     *
     * @return boolean True if this visitor is done.
     */
    public function isDone()
    {
        return false;
    }
}
//}>a
?>
