<?php
/**
 * @copyright Copyright &copy; 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: MultiDimensionalArray.php,v 1.8 2005/12/09 01:11:13 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractObject.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/Exceptions.php';
require_once 'Opus11/Box.php';

//{
/**
 * Represents a multi-dimensional array.
 *
 * @package Opus11
 */
class MultiDimensionalArray
    extends AbstractObject
    implements ArrayAccess
{
    /**
     * @var object BasicArray The dimensions of the array.
     */
    protected $dimensions = NULL;
    /**
     * @var object BasicArray
     * Used in the calculation that maps a set of indices
     * into a position in a one-dimensional array.
     */
    protected $factors = NULL;
    /**
     * @var object BasicArray
     * A one-dimensional array that holds the elements
     * of the multi-dimensional array.
     */
    protected $data = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a MultiDimensionalArray with the specified dimensions.
     *
     */
    public function __construct($dimensions)
    {
        parent::__construct();
        $length = sizeof($dimensions);
        $this->dimensions = new BasicArray($length);
        $this->factors = new BasicArray($length);
        $product = 1;
        for ($i = $length - 1; $i >= 0; --$i)
        {
            $this->dimensions[$i] = $dimensions[$i];
            $this->factors[$i] = $product;
            $product *= $this->dimensions[$i];
        }
        $this->data = new BasicArray($product);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->dimesions = NULL;
        $this->factors = NULL;
        $this->data = NULL;
        parent::__destruct();
    }
//}>a

//{
    /**
     * Maps a set of indices for the multi-dimensional array
     * into the corresponding position in the one-dimensional array.
     *
     * @param array $indices The set of indices.
     */
    private function getOffset($indices)
    {
        if (sizeof($indices) != $this->dimensions->getLength())
            throw new IndexError();
        $offset = 0;
        for ($i = 0; $i < $this->dimensions->getLength(); ++$i)
        {
            if ($indices[$i] < 0 ||
                $indices[$i] >= $this->dimensions[$i])
                throw new IndexError();
            $offset += $this->factors[$i] * $indices[$i];
        }
        return $offset;
    }

    /**
     * Returns true if the given set of indices is valid.
     *
     * @param array $indices A set of indices.
     * @return boolean True if the given set of indices is valid.
     */
    public function offsetExists($indices)
    {
        $this->getOffset($indices);
    }

    /**
     * Returns the item in this array at the given indices.
     *
     * @param array $indices A set of indices.
     * @return mixed The item at the given indices.
     */
    public function offsetGet($indices)
    {
        return $this->data[$this->getOffset($indices)];
    }

    /**
     * Sets the item in this array at the given indices to the given value.
     *
     * @param array $indices A set of indices.
     * @param mixed $value A value.
     */
    public function offsetSet($indices, $value)
    {
        $this->data[$this->getOffset($indices)] = $value;
    }

    /**
     * Unsets the item in this array at the given indices.
     *
     * @param array $indices A set of indices.
     */
    public function offsetUnset($indices)
    {
        $this->data[$this->getOffset($indices)] = NULL;
    }
//}>b

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("MultiDimensionalArray main program.\n");
        $status = 0;

        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(MultiDimensionalArray::main(array_slice($argv, 1)));
}
?>
