<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: PrintingVisitor.php,v 1.3 2005/12/09 01:11:15 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractVisitor.php';

//{
/**
 * Printing visitor.
 *
 * @package Opus11
 */
class PrintingVisitor
    extends AbstractVisitor
{
    /**
     * @var resource The output stream.
     */
    protected $stream = NULL;

    /**
     * Constructs this PrintingVisitor.
     */
    public function __construct($stream)
    {
        parent::__construct();
        $this->stream = $stream;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->stream = NULL;
        parent::__destruct();
    }

    /**
     * Prints the given object.
     *
     * @param object IObject $obj An object.
     */
    public function visit(IObject $obj)
    {
        fprintf($this->stream, "%s\n", str($obj));
    }
}
//}>a
?>
