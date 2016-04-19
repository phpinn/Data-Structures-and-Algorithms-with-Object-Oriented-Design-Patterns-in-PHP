<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Association.php,v 1.6 2005/12/09 01:11:06 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractComparable.php';
require_once 'Opus11/Box.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * Represents a (key, value) pair.
 *
 * @package Opus11
 */
class Association
    extends AbstractComparable
{
    /**
     * @var object IComparable The key.
     */
    protected $key = NULL;
    /**
     * @var object IComparable The value.
     */
    protected $value = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs an Associationwith the specified key and value.
     *
     * @param object IComparable $key The desired key.
     * @param mixed value The desired value.
     */
    public function __construct(IComparable $key, $value = NULL)
    {
        parent::__construct();
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->key = NULL;
        $this->value = NULL;
        parent::__destruct();
    }

    /**
     * Key getter.
     *
     * @return object IComparable The key of this association.
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Value getter.
     *
     * @return mixed The value of this association.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Value setter.
     *
     * @param object IComparable $value A value.
     */
    public function setValue(IComparable $value)
    {
        $this->value = $value;
    }

    /**
     * Value unsetter.
     */
    public function unsetValue()
    {
        $this->value = NULL;
    }
//}>b

//{
    /**
     * Compares this association with the specified comparable object.
     * The specified comparable object is assumed to be an Association instance.
     * The two associations are compared by comparing just their keys.
     *
     * @param object IComparable $obj
     * The object with which this object is compared.
     * @return integer A number less than zero if the key of this association
     * is less than the key of the specified one;
     * a number greater than zero if the key of this association
     * is greater than the key of the specified one;
     * zero if the keys of both associations are equal.
     */
    protected function compareTo(IComparable $obj)
    {
        return $this->key->compare($obj->getKey());
    }

    /**
     * Returns a textual representation of this association.
     *
     * @return string A string.
     */
    public function __toString()
    {
        $result = 'Association{' . str($this->key);
        if ($this->value !== NULL)
            $result .= ', ' . str($this->value);
        return $result . '}';
    }
//}>c

//{
    /**
     * Returns a hashcode for this association.
     * The hashcode of an this association
     * is just the hashcode of the key.
     *
     * @return integer A hashcode for this association.
     */
    public function getHashCode()
    {
        return $this->key->getHashCode();
    }
//}>d

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Association main program.\n");
        $status = 0;
        $a1 = new Association(box(1), NULL);
        printf("%s\n", str($a1));
        $a2 = new Association(box(2), box(4));
        printf("%s\n", str($a2));
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Association::main(array_slice($argv, 1)));
}
?>
