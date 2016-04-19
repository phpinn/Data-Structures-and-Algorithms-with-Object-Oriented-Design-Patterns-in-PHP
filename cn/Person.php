<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Person.php,v 1.3 2005/12/09 01:11:15 brpreiss Exp $
 * @package Opus11
 */

//{
/**
 * Records some basic information about a person.
 *
 * @package Opus11
 */
class Person
{
    /**
     * @var integer Sex: male.
     */
    const MALE = 0;
    /**
     * @var integer Sex female.
     */
    const FEMALE = 1;

    /**
     * @var string The name of this person.
     */
    protected $name;
    /**
     * @var integer The sexo of this person.
     */
    protected $sex;

    /**
     * Constructs a Person with the given name and sex.
     *
     * @param string The name of this person.
     * @param integer The sex of this person.
     */
    public function __construct($name, $sex)
    {
        $this->name = $name;
        $this->sex = $sex;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
    }

    /**
     * Returns the name of this person.
     *
     * @return string The name of this person.
     */
    public function __toString()
    {
        return $this->name;
    }
}
//}>a
?>
