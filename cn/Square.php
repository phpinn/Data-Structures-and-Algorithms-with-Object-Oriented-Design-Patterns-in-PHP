<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Square.php,v 1.2 2005/12/09 01:11:17 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Rectangle.php';

//{
/**
 * A square graphical object.
 *
 * @package Opus11
 */
class Square
    extends Rectangle
{
    /**
     * Constructs a Square with the specified center point and width.
     *
     * @param object Point $p The center point of this square.
     * @param integer $width The width of this square.
     */
    public function __construct(Point $p, $width)
    {
        parent::__construct($p, $width, $width);
    }
}
//}>a
?>
