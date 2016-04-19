<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ReducingVisitor.php,v 1.4 2005/12/09 01:11:16 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractVisitor.php';

//{
/**
 * Reducing visitor.
 *
 * @package Opus11
 */
class ReducingVisitor
    extends AbstractVisitor
{
    /**
     * @var callback The callback function.
     */
    protected $callback = NULL;
    /**
     * @var mixed The state.
     */
    protected $state = NULL;

    /**
     * Constructs this ReducingVisitor.
     *
     * @param callback $callback A callback function.
     * @param mixed $initialState The initial state.
     */
    public function __construct($callback, $initialState)
    {
        parent::__construct();
        $this->callback = $callback;
        $this->state = $initialState;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->callback = NULL;
        $this->state = NULL;
        parent::__destruct();
    }

    /**
     * State getter.
     *
     * @return mixed The state.
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Visits the given object.
     *
     * @param object IObject $obj An object.
     */
    public function visit(IObject $obj)
    {
        $callback = $this->callback;
        $this->state = $callback($this->state, $obj);
    }
}
//}>a
?>
