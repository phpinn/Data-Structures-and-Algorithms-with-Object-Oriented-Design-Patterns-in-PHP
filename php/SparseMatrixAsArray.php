<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: SparseMatrixAsArray.php,v 1.8 2005/12/09 01:11:17 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractMatrix.php';
require_once 'Opus11/ISparseMatrix.php';
require_once 'Opus11/DenseMatrix.php';
require_once 'Opus11/Exceptions.php';

/**
 * A sparse matrix implemented using arrays.
 *
 * @package Opus11
 */
class SparseMatrixAsArray
    extends AbstractMatrix
    implements ISparseMatrix
{
    /**
     * @var integer
     * The maximum number of non-zero entries in any row of the sparse matrix.
     */
    protected $fill = 0;
    /**
     * @var object DenseMatrix
     * The non-zero matrix entries.
     */
    protected $values = NULL;
    /**
     * @var object DenseMatrix
     * The column numbers corresponding to the non-zero entries.
     */
    protected $columns = NULL;

    /**
     * @var integer
     * An invalid column number to mark the end of a row.
     */
    const END_OF_ROW = -1;

    /**
     * Construct a SparseMatrixAsArray
     * with the specified dimensions and row fill.
     *
     * @param integer $numRows The number of rows.
     * @param integer $numCols The number of columns.
     * @param integer $fill The maximum number of non-zero entries in any row.
     */
    public function __construct(
        $numRows, $numCols, $fill)
    {
        parent::__construct($numRows, $numCols);
        $this->fill = $fill;
        $this->values = new DenseMatrix($numRows, $fill);
        $this->columns = new DenseMatrix($numRows, $fill);
        for ($i = 0; $i < $this->numRows; ++$i)
        {
            $this->columns[array($i, 0)] = self::END_OF_ROW;
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->values = NULL;
        $this->columns = NULL;
        parent::__destruct();
    }

    /**
     * Finds the position of the (i,j)th matrix entry.
     *
     * @param integer $i The row number.
     * @param integer $j The column number.
     * @return integer The position of the (i,j)th matrix entry;
     * -1 if the matrix entry is zero.
     */
    protected function findPosition($i, $j)
    {
        $result = -1;
        for ($k = 0; $k < $this->fill &&
            $this->columns[array($i, $k)] != self::END_OF_ROW; ++$k)
        {
            if ($this->columns[array($i, $k)] == $j)
            {
                $result = $k;
                break;
            }
        }
        return $result;
    }

    /**
     * Returns true if the given set of indices is valid.
     *
     * @param array $indices A set of indices.
     * @return boolean True if the given set of indices is valid.
     */
    public function offsetExists($indices)
    {
        return $indices[0] >= 0 &&
            $indices[0] < $this->numRows &&
            $indices[1] >= 0 &&
            $indices[1] < $this->numCols;
    }

    /**
     * Returns the value in this matrix at the specified indices.
     *
     * @param array $indices A set of indices.
     * @return mixed The value in this matrix at the specified indices.
     */
    public function offsetGet($indices)
    {
        if (!$this->offsetExists($indices))
            throw new IndexError();
        $i = $indices[0];
        $j = $indices[1];
        $position = $this->findPosition($i, $j);
        if ($position >= 0)
            return $this->values[array($i, $position)];
        else
            return 0;
    }

    /**
     * Stores the given value in this matrix at the specified indices.
     *
     * @param array $indices A set of indices.
     * @param mixed $datum The value to be stored.
     */
    public function offsetSet($indices, $datum)
    {
        if (!$this->offsetExists($indices))
            throw new IndexError();
        $i = $indices[0];
        $j = $indices[1];
        $position = $this->findPosition ($i, $j);
        if ($position >= 0)
            $this->values[array($i, $position)] = $datum;
        else
        {
            $k = 0;
            while ($k < $this->fill &&
                $this->columns[array($i, $k)] != self::END_OF_ROW)
                ++$k;
            if ($k >= $this->fill)
                throw new ContainerFullException();
            if ($k < $this->fill - 1)
                $this->columns[array($i, $k + 1)] = self::END_OF_ROW;
            while ($k > 0 && $this->columns[array($i, $k)] >= $j)
            {
                $this->values[array($i, $k)] =
                    $this->values[array($i, $k - 1)];
                $this->columns[array($i, $k)] =
                    $this->columns[array($i, $k - 1)];
                --$k;
            }
            $this->values[array($i, $k)] = $datum;
            $this->columns[array($i, $k)] = $j;
        }
    }

    /**
     * Stores a zero in this matrix at the specified indices.
     *
     * @param array $indices A set of indices.
     * @param mixed $datum The value to be stored.
     */
    public function offsetUnset($indices)
    {
        $this->putZero($indices);
    }

    /**
     * Stores a zero in this matrix at the specified indices.
     *
     * @param array $indices A set of indices.
     */
    public function putZero($indices)
    {
        if (!$this->offsetExists($indices))
            throw new IndexError();
        $i = $indices[0];
        $j = $indices[1];
        $position = $this->findPosition($i, $j);
        if ($position >= 0)
        {
            $k = 0;
            for ($k = $position; $k < $this->numCols - 1
                    && $this->columns[array($i, $k + 1)] != self::END_OF_ROW;
                    ++$k)
            {
                $this->values[array($i, $k)] =
                    $this->values[array($i, $k + 1)];
                $this->columns[array($i, $k)] =
                    $this->columns[array($i, $k + 1)];
            }
            if ($k < $this->numCols)
                $this->columns[array($i, $k)] = self::END_OF_ROW;
        }
    }

    /**
     * Returns the transpose of this matrix.
     * This method is not implemented.
     *
     * @return object SparseMatrixAsArray The transpose of this matrix.
     */
    public function getTranspose()
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Returns the product of this matrix and the specified matrix.
     * This method is not implemented.
     *
     * @param object IMatrix $mat The specified matrix.
     * @return SparseMatrixAsArray
     * The product of this matrix and the specified matrix
     */
    public function times(IMatrix $mat)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Returns the sum of this matrix and the specified matrix.
     * This method is not implemented.
     *
     * @param object IMatrix $mat The specified matrix.
     * @return object SparseMatrixAsArray 
     * The sum of this matrix and the specified matrix
     * @exception MethodNotImplemented Always.
     */
    public function plus(IMatrix $mat)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("SparseMatrixAsArray main program.\n");
        $status = 0;

        $mat = new SparseMatrixAsArray(6, 6, 6);
        AbstractMatrix::test($mat);
        AbstractMatrix::testTranspose($mat);

        $mat1 = new SparseMatrixAsArray(3, 3, 3);
        $mat2 = new SparseMatrixAsArray(3, 3, 3);
        AbstractMatrix::testTimes($mat1, $mat2);

        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(SparseMatrixAsArray::main(array_slice($argv, 1)));
}
?>
