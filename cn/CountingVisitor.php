<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: CountingVisitor.php,v 1.2 2005/12/09 01:11:09 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractVisitor.php';

//{
/**
 * Counting visitor.
 *
 * @package Opus11
 */
class CountingVisitor
    extends AbstractVisitor
{
    /**
     * @var integer The count.
     */
    protected $count = 0;

    /**
     * Constructs this CountingVisitor.
     *
     * @param integer $count The initial count.
     */
    public function __construct($count = 0)
    {
        parent::__construct();
        $this->count = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Count getter.
     *
     * @return integer The count.
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Count setter.
     *
     * @param count The count.
     */
    public function setCount($count)
    {
        $this->count = count;
    }

    /**
     * Counts the given object.
     *
     * @param object IObject $obj An object.
     */
    public function visit(IObject $obj)
    {
        ++$this->count;
    }
}
//}>a
?>
