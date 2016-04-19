<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Rectangle.php,v 1.2 2005/12/09 01:11:16 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/GraphicalObject.php';

//{
/**
 * A rectangular graphical object.
 *
 * @package Opus11
 */
class Rectangle
    extends GraphicalObject
{
    /**
     * @var integer The height of the rectangle.
     */
    protected $height = 0;
    /**
     * @var integer The width of the rectangle.
     */
    protected $width = 0;

    /**
     * Constructs a Rectangle with the specified center point,
     * height and width.
     *
     * @param object Point $p The center point of this rectangle.
     * @param integer $height The height of this rectangle.
     * @param integer $width The width of this rectangle.
     */
    public function __construct(Point $p, $height, $width)
    {
        parent::__construct($p);
        $this->height = $height;
        $this->width = $width;
    }

    /**
     * Draws this rectangle.
     */
    public function draw()
        { /* ... */ }
}
//}>a
?>
