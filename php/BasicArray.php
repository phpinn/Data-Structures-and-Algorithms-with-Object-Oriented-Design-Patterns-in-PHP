<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: BasicArray.php,v 1.12 2005/12/09 01:11:07 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractObject.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * A basic array class.
 *
 * @package Opus11
 */
class BasicArray
    extends AbstractObject
    implements ArrayAccess
{
    /**
     * The array data.
     */
    protected $data = NULL;
    /**
     * The length of the array.
     */
    protected $length = 0;
    /**
     * The base index of the array.
     */
    protected $baseIndex = 0;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a BasicArray.
     *
     * @param mixed $arg1 Either an integer or an array.
     * If an integer, this argument specifies the array length.
     * If an array, this array is initialized with contents of the given array.
     * @param integer $arg2 The base index. (Optional).
     */
    public function __construct($arg1 = 0, $baseIndex = 0)
    {
        parent::__construct();
        if (gettype($arg1) == 'integer')
        {
            $this->length = $arg1;
            $this->data = array();
            for ($i = 0; $i < $this->length; ++$i)
            {
                $this->data[$i] = NULL;
            }
            $this->baseIndex = $baseIndex;
        }
        elseif (gettype($arg1) == 'array')
        {
            $this->length = sizeof($arg1);
            $this->data = array();
            for ($i = 0; $i < $this->length; ++$i)
            {
                $this->data[$i] = $arg1[$i];
            }
            $this->baseIndex = $baseIndex;
        }
        else
        {
            throw new TypeError();
        }
    }
//}>a

//{
    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->data = NULL;
        parent::__destruct();
    }
//}>b

//{
    /**
     * Returns a clone of this array.
     * @return object BasicArray A BasicArray.
     */
    public function __clone()
    {
        $result = new BasicArray(
            $this->length, $this->baseIndex);
        for ($i = 0; $i < $this->length; ++$i)
        {
            $result->data[$i] = $this->data[$i];
        }
        return $result;
    }
//}>c

//{
    /**
     * Returns true if the given index is valid.
     *
     * @param integer $index An index.
     * @return boolean True if the given index is valid.
     */
    public function offsetExists($index)
    {
        return $index >= $this->baseIndex &&
            $index <= $this->baseIndex + $this->length;
    }

    /**
     * Returns the item in this array at the given index.
     *
     * @param integer $index An index.
     * @return mixed The item at the given index.
     */
    public function offsetGet($index)
    {
        if (!$this->offsetExists($index))
            throw new IndexError();
        return $this->data[$index - $this->baseIndex];
    }

    /**
     * Sets the item in this array at the given index to the given value.
     *
     * @param integer $index An index.
     * @param mixed $value A value.
     */
    public function offsetSet($index, $value)
    {
        if (!$this->offsetExists($index))
            throw new IndexError();
        $this->data[$index - $this->baseIndex] = $value;
    }

    /**
     * Unsets the item in this array at the given index.
     *
     * @param integer $index An index.
     */
    public function offsetUnset($index)
    {
        if (!$this->offsetExists($index))
            throw new IndexError();
        $this->data[$index - $this->baseIndex] = NULL;
    }
//}>d

//{
    /**
     * Data getter.
     *
     * @return array The data of this array.
     */
    public function & getData()
    {
        return $this->data;
    }

    /**
     * BaseIndex getter.
     *
     * @return integer The base index of this array.
     */
    public function getBaseIndex()
    {
        return $this->baseIndex;
    }

    /**
     * BaseIndex setter.
     *
     * @param integer $baseIndex A base index.
     */
    public function setBaseIndex($baseIndex)
    {
        $this->baseIndex = $baseIndex;
    }
//}>e

//{
    /**
     * Length getter.
     *
     * @return integer The length of this array.
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Length setter.
     *
     * @param integer $length A length.
     */
    public function setLength($length)
    {
        if ($this->length != $length)
        {
            $newData = array();
            $min = $this->length < $length ?
                $this->length : $length;
            for ($i = 0; $i < $min; ++$i)
            {
                $newData[$i] = $this->data[$i];
            }
            for ($i = $min + 1; $i < $length; ++$i)
            {
                $newData[$i] = NULL;
            }
            $this->data = $newData;
            $this->length = $length;
        }
    }
//}>f

    /**
     * Returns a value computed by calling the given callback function
     * for each item in this array.
     * Each time the callback function will be called with two arguments:
     * The first argument is the next item in this array.
     * The first time the callback function is called,
     * the second argument is the given initial value.
     * On subsequent calls to the callback function,
     * the second argument is the result returned from
     * the previous call to the callback function.
     *
     * @param callback $callback A callback function.
     * @param mixed $initialState The initial state.
     * @return mixed The value returned by
     * the last call to the callback function.
     */
    public function reduce($callback, $initialState)
    {
        return array_reduce($this->data, $callback, $initialState);
    }

    /**
     * Returns a textual representation of this array.
     *
     * @return string A string.
     */
    public function __toString()
    {
        $s = $this->reduce(
            create_function(
                '$s, $item', 
                'return array($s[0] . $s[1] . str($item), ", ");'
            ), array('',''));
        return 'Array{baseIndex=' . $this->baseIndex .
            ', data=(' . $s[0] . ')}';
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("BasicArray main program.\n");
        $status = 0;

        $a1 = new BasicArray(3);
        $a1[0] = 2;
        $a1[1] = $a1[0] + 2;
        $a1[2] = $a1[1] + 2;
        printf("a1 = %s\n", str($a1));
        printf("baseIndex = %d\n", $a1->getBaseIndex());
        printf("length = %d\n", $a1->getLength());

        $a2 = new BasicArray(1, 10);
        $a2[10] = 57;
        printf("a2 = %s\n", str($a2));
        printf("baseIndex = %d\n", $a2->getBaseIndex());
        printf("length = %d\n", $a2->getLength());
        $a2->setLength(5);
        printf("a2 = %s\n", str($a2));
        printf("length = %d\n", $a2->getLength());
        $a2->setLength(3);
        printf("a2 = %s\n", str($a2));
        printf("length = %d\n", $a2->getLength());
        $a3 = clone($a2);
        printf("a3 = %s\n", str($a3));

        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(BasicArray::main(array_slice($argv, 1)));
}
?>
