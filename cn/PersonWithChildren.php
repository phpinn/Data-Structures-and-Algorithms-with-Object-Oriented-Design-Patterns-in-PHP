<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: PersonWithChildren.php,v 1.3 2005/12/09 01:11:15 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Person.php';

//{
/**
 * Records some basic information about a person with children.
 *
 * @package Opus11
 */
class PersonWithChildren
    extends Person
{
    /**
     * @var array The children of this person.
     */
    protected $children;

    /**
     * Constructs a PersonWithChildren with the given name, sex and children.
     *
     * @param string The name of this person.
     * @param integer The sex of this person.
     * @param array The children of this person.
     */
    public function __construct($name, $sex, $children)
    {
        parent::__construct($name, $sex);
        $this->children = $children;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Returns the specified child of this person.
     *
     * @param integer $i The specified child.
     */
    public function getChild($i)
    {
        return $this->children[$i];
    }

    /**
     * Returns the name of this person.
     *
     * @return string The name of this person.
     */
    public function __toString()
    {
//!     // ...
//[
        return parent::__toString();
//]
    }
}
//}>a
?>
