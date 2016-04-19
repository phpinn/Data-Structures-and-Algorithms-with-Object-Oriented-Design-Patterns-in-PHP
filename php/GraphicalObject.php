<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: GraphicalObject.php,v 1.2 2005/12/09 01:11:12 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IGraphicsPrimitives.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * The GraphicalObject class is the base class
 * from which various concrete graphical object classes are derived.
 *
 * @package Opus11
 */
abstract class GraphicalObject
    implements IGraphicsPrimitives
{
    /**
     * @var object Point The center point of this graphical object.
     */
    protected $center;

//}@head

//{
//!    // ...
//!}
//}@tail

    /**
     * The background color.
     */
    const BACKGROUND_COLOR = 0;
    /**
     * The foreground color.
     */
    const FOREGROUND_COLOR = 1;

//{
    /**
     * Constructs a GraphicalObject
     * with the specified center point.
     *
     * @param object Point $p The center point.
     */
    public function __construct(Point $p)
    {
        $this->center = $p;
    }

    /**
     * Erases this graphical object.
     */
    public function erase()
    {
        $this->setPenColor(self::BACKGROUND_COLOR);
        $this->draw();
        $this->setPenColor(self::FOREGROUND_COLOR);
    }

    /**
     * Moves this graphical object to the specified point.
     *
     * @param object Point $p The specified point.
     */
    public function moveTo(Point $p)
    {
        $this->erase();
        $this->center = $p;
        $this->draw();
    }
//}>a

    /**
     * Sets the pen to the specified color.
     * This method is not yet implemented.
     *
     * @param integer $color The desired color of pen.
     */
    public function setPenColor($color)
    {
        throw new MethodNotImplementedException();
    }
}
?>
