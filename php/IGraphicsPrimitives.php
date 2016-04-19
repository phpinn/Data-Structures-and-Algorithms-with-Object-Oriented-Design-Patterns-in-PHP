<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IGraphicsPrimitives.php,v 1.1 2005/12/09 00:45:15 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Point.php';

//{
/**
 * Encapsulates a simple set of primitive operations on graphical objects.
 *
 * @package Opus11
 */
interface IGraphicsPrimitives
{
    /**
     * Draws this graphical object on the screen.
     */
    public abstract function draw();
    /**
     * Erases this graphical object from the screen.
     */
    public abstract function erase();
    /**
     * Moves this graphical object to a given point on the screen.
     *
     * @param object Point $p The point to which this object is to be moved.
     */
    public abstract function moveTo(Point $p);
}
//}>a
?>
