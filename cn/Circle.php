<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Circle.php,v 1.2 2005/12/09 01:11:09 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/GraphicalObject.php';

//{
/**
 * A circular graphical object.
 *
 * @package Opus11
 */
class Circle
    extends GraphicalObject
{
    /**
     * @var integer The radius of the circle.
     */
    protected $radius = 0;

    /**
     * Constructs a Circle with the specified center point and radius.
     *
     * @param object Point $p The center point of this circle.
     * @param integer $radius The radius of this circle.
     */
    public function __construct(Point $p, $radius)
    {
        parent::__construct($p);
        $this->radius = $radius;
    }

    /**
     * Draws this circle.
     */
    public function draw()
        { /* ... */ }
}
//}>a
?>
