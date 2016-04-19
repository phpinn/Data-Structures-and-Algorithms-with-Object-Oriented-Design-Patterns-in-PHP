<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IRandomVariable.php,v 1.3 2005/11/27 23:32:32 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IObject.php';

//{
/**
 * Interface implemented by all random variables.
 *
 * @package Opus11
 */
interface IRandomVariable
    extends IObject
{
    /**
     * Returns the next sample.
     *
     * @return float The next sample.
     */
    public abstract function next();
}
//}>a
?>
