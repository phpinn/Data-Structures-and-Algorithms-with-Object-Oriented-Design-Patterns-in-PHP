<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: DenseMatrix.php,v 1.11 2005/12/09 01:11:10 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractMatrix.php';
require_once 'Opus11/MultiDimensionalArray.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * A dense matrix implemented using a multi-dimensional array with 2 dimensions.
 *
 * @package Opus11
 */
class DenseMatrix
    extends AbstractMatrix
{
    /**
     * @var object MultiDimensionalArray The multi-dimensional array.
     */
    protected $array = NULL;

//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a DenseMatrix with the given number of rows and columns.
     *
     * @param integer $rows The number of rows.
     * @param integer $columns The number of columns.
     */
    public function __construct($rows, $columns)
    {
        parent::__construct($rows, $columns);
        $this->array =
            new MultiDimensionalArray(array($rows, $columns));
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->array = NULL;
        parent::__destruct();
    }
//}>a

//{
    /**
     * Returns true if the given indices are valid.
     *
     * @param array $indices A set of indices.
     * @return boolean True if the given indices are valid.
     */
    public function offsetExists($indices)
    {
        return $this->array->offsetExists($indices);
    }

    /**
     * Returns the item in this array at the given indices.
     *
     * @param array $indices A set of indices.
     * @return mixed The item at the given indices.
     */
    public function offsetGet($indices)
    {
        return $this->array[$indices];
    }

    /**
     * Sets the item in this array at the given indices to the given value.
     *
     * @param array $indices A set of indices.
     * @param mixed $value A value.
     */
    public function offsetSet($indices, $value)
    {
        $this->array[$indices] = $value;
    }

    /**
     * Unsets the item in this array at the given indices.
     *
     * @param array $indices A set of indices.
     */
    public function offsetUnset($indices)
    {
        $this->array[$indices] = NULL;
    }
//}>b

//{
    /**
     * Returns the product of this dense matrix and the given dense matrix.
     *
     * @param object DenseMatrix $mat A dense matrix.
     * @return object DenseMatrix The product.
     */
    public function times(IMatrix $mat)
    {
        if (!($mat instanceof self) ||
            $this->getNumCols() != $mat->getNumRows())
            throw new ArgumentError();
        $result = new DenseMatrix(
            $this->getNumRows(), $mat->getNumCols());
        for ($i = 0; $i < $this->getNumRows(); ++$i)
        {
            for ($j = 0; $j < $mat->getNumCols(); ++$j)
            {
                $sum = 0;
                for ($k = 0; $k < $this->getNumCols(); ++$k)
                {
                    $sum += $this[array($i, $k)] *
                        $mat[array($k, $j)];
                }
                $result[array($i, $j)] = $sum;
            }
        }
        return $result;
    }
//}>c

    /**
     * Returns the sum of this dense matrix and the given dense matrix.
     *
     * @param object DenseMatrix $mat A dense matrix.
     * @return object DenseMatrix The sum.
     */
    public function plus(IMatrix $mat)
    {
        if (!($mat instanceof self) ||
            $this->getNumRows() != $mat->getNumRows() ||
            $this->getNumCols() != $mat->getNumCols())
            throw new ArgumentError();
        $result = new DenseMatrix(
            $this->getNumRows(), $this->getNumCols());
        for ($i = 0; $i < $this->getNumRows(); ++$i)
        {
            for ($j = 0; $j < $this->getNumCols(); ++$j)
            {
                $result[array($i, $j)] =
                    $this[array($i, $j)] + $mat[array($i, $j)];
            }
        }
        return $result;
    }

    /**
     * Returns the transpose of this dense matrix.
     *
     * @return object DenseMatrix The tranpose.
     */
    public function getTranspose()
    {
        $result = new DenseMatrix(
            $this->getNumCols(), $this->getNumRows());
        for ($i = 0; $i < $this->getNumRows(); ++$i)
        {
            for ($j = 0; $j < $this->getNumCols(); ++$j)
            {
                $result[array($j, $i)] = $this[array($i, $j)];
            }
        }
        return $result;
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("DenseMatrix main program.\n");
        $status = 0;

        $mat = new DenseMatrix(6, 6);
        AbstractMatrix::test($mat);
        AbstractMatrix::testTranspose($mat);
        AbstractMatrix::testTimes($mat, $mat);

        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(DenseMatrix::main(array_slice($argv, 1)));
}
?>
