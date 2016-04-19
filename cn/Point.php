<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Point.php,v 1.1 2005/12/09 00:45:15 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractComparable.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * Represents a point in the Cartesian plane.
 *
 * @package Opus11
 */
class Point
{
    /**
     * @var integer The abscissa.
     */
    protected $x = 0;
    /**
     * @var integer The ordinate.
     */
    protected $y = 0;

    /**
     * Constructs a point with the specified x and y coordinates.
     *
     * @param integer $x The abscissa.
     * @param integer $y The ordinate.
     */
    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }
    // ...
}
//}>a
?>
