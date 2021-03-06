<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: PreOrder.php,v 1.4 2005/12/09 01:11:15 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractPrePostVisitor.php';

//{
/**
 * Adapter to convert a IVisitor to a IPrePostVisitor
 *
 * @package Opus11
 */
class PreOrder
    extends AbstractPrePostVisitor
{
    /**
     * @var object IVisitor A visitor.
     */
    protected $visitor = NULL;

    /**
     * Constructs this PreOrder.
     */
    public function __construct($visitor)
    {
        $this->visitor = $visitor;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->visitor = NULL;
    }

    /**
     * "Pre"-visit the given object.
     * Calls the visit method of the underlying visitor.
     *
     * @param object IObject $obj An object.
     */
    public function preVisit(IObject $obj)
    {
        $this->visitor->visit($obj);
    }

    /**
     * Done predicate.
     *
     * @return boolean True if this visitor is done.
     */
    public function isDone()
    {
        return $this->visitor->isDone();
    }
}
//}>a
?>
