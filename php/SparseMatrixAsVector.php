<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: SparseMatrixAsVector.php,v 1.8 2005/12/09 01:11:17 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractMatrix.php';
require_once 'Opus11/ISparseMatrix.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/Exceptions.php';

/**
 * Data structure used to represent a matrix entry.
 *
 * @package Opus11
 */
class SparseMatrixAsVector_Entry
{
    /**
     * @var integer The row number.
     */
    protected $row;
    /**
     * @var integer The column number.
     */
    protected $column;
    /**
     * @var mixed The matrix entry.
     */
    protected $datum;

    /**
     * Construct an Entry with the specified values.
     *
     * @param integer $row The row number.
     * @param integer $column The column number.
     * @param mixed $datum The matrix entry.
     */
    public function __construct($row = 0, $column = 0, $datum = 0)
    {
        $this->row = $row;
        $this->column = $column;
        $this->datum = $datum;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
    }

    /**
     * Row getter.
     *
     * @return integer The row.
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * Column getter.
     *
     * @return integer The column.
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * Datum getter.
     *
     * @return mixed The datum.
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * Datum setter.
     *
     * @param mixed $datum The datum.
     */
     public function setDatum($datum)
     {
        $this->datum = $datum;
     }

     /**
      * Returns a textual representation of this matrix entry.
      *
      * @return string A string.
      */
    public function __toString()
    {
        return sprintf("[%d,%d]=%s",
            $this->row, $this->column, str($this->datum));
    }
}

/**
 * A sparse matrix implemented using a vector of triples.
 *
 * @package Opus11
 */
class SparseMatrixAsVector
    extends AbstractMatrix
    implements ISparseMatrix
{
    /**
     * @var integer The maximum number of non-zero elements in this matrix.
     */
    protected $numberOfElements = 0;
    /**
     * @var object BasicArray An array of triples (entries).
     */
    protected $array = NULL;

    /**
     * Construct a SparseMatrixAsVector
     * with the specified dimensions and maximum number of non-zero elements.
     *
     * @param integer $numRows The number of rows.
     * @param integer $numCols The number of columns.
     * @param integer $maxElements The maximum number of non-zero elements
     * in this matrix.
     */
    public function __construct(
        $numRows, $numCols, $maxElements)
    {
        parent::__construct($numRows, $numCols);
        $this->array = new BasicArray($maxElements);
        for ($i = 0; $i < $maxElements; ++$i)
        {
            $this->array[$i] = new SparseMatrixAsVector_Entry();
        }
        $this->numberOfElements = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->array = NULL;
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
        $target = $i * $this->numCols + $j;
        $left = 0;
        $right = $this->numberOfElements - 1;
        while ($left <= $right)
        {
            $middle = intval(($left + $right) / 2);
            $probe = $this->array[$middle]->getRow() * $this->numCols
                + $this->array[$middle]->getColumn();
            if ($target > $probe)
                $left = $middle + 1;
            elseif ($target < $probe)
                $right = $middle - 1;
            else
                return $middle;
        }
        return -1;
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
     * @return mixed The value in this matrix at the specified position.
     */
    public function offsetGet($indices)
    {
        if (!$this->offsetExists($indices))
            throw new IndexError();
        $i = $indices[0];
        $j = $indices[1];
        $position = $this->findPosition($i, $j);
        if ($position >= 0)
            return $this->array[$position]->getDatum();
        else
            return 0;
    }

    /**
     * Stores the specified value in this matrix at the specified indices.
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
        $position = $this->findPosition($i, $j);
        if ($position >= 0)
            $this->array[$position]->setDatum($datum);
        else
        {
            if ($this->array->getLength() == $this->numberOfElements)
            {
                $newArray = new BasicArray(2 * $this->array->getLength());
                for ($k = 0; $k < $this->array->getLength(); ++$k)
                {
                    $newArray[$k] = $this->array[$k];
                }
                for ($k = $this->array->getLength();
                    $k < $newArray->getLength(); ++$k)
                {
                    $newArray[$k] = new SparseMatrixAsVector_Entry();
                }
                $this->array = $newArray;
            }
            $k = $this->numberOfElements;
            while ($k > 0 && ($this->array[$k - 1]->getRow() > $i ||
                    $this->array[$k - 1]->getRow() == $i &&
                    $this->array[$k - 1]->getColumn() >= $j))
            {
                $this->array[$k] = $this->array[$k - 1];
                --$k;
            }
            $this->array[$k] = new SparseMatrixAsVector_Entry($i, $j, $datum);
            ++$this->numberOfElements;
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
        $position = $this->findPosition($i, $j);
        if ($position >= 0)
        {
            --$this->numberOfElements;
            $k = 0;
            for ($k = $position; $k < $this->numberOfElements; ++$k)
                $this->array[$k] = $this->array[$k + 1];
            $this->array[$k] = new SparseMatrixAsVector_Entry();
        }
    }

    /**
     * Returns the transpose of this matrix.
     *
     * @return object SparseMatrixAsVector The transpose.
     */
    public function getTranspose()
    {
        $result = new SparseMatrixAsVector($this->numCols, $this->numRows,
            $this->numberOfElements);
        $offset = new BasicArray($this->numCols);
        for ($i = 0; $i < $this->numCols; ++$i)
            $offset[$i] = 0;
        for ($i = 0; $i < $this->numberOfElements; ++$i)
        {
            $pos = $this->array[$i]->getColumn();
            $offset[$pos] = $offset[$pos] + 1;
        }
        $sum = 0;
        for ($i = 0; $i < $this->numCols; ++$i)
        {
            $tmp = $offset[$i];
            $offset[$i] = $sum;
            $sum += $tmp;
        }
        for ($i = 0; $i < $this->numberOfElements; ++$i)
        {
            $pos = $this->array[$i]->getColumn();
            $result->array[$offset[$pos]] =
                new SparseMatrixAsVector_Entry
                    ($this->array[$i]->getColumn(), $this->array[$i]->getRow(),
                    $this->array[$i]->getDatum());
            $offset[$pos] = $offset[$pos] + 1;
        }
        $result->numberOfElements = $this->numberOfElements;
        return $result;
    }

    /**
     * Returns the product of this matrix and the specified matrix.
     * @param object IMatrix $mat The specified matrix.
     * @return object SparseMatrixAsVector
     * The product of this matrix and the specified matrix
     */
    public function times(IMatrix $mat)
    {
        if ($this->numCols != $mat->numRows)
            throw new ArgumentError();
        $matT = $mat->getTranspose();
        $result = new SparseMatrixAsVector(
            $this->numRows, $matT->numRows,
            $this->numRows + $matT->numRows);
        for ($iPosition = 0; $iPosition < $this->numberOfElements; )
        {
            $i = $this->array[$iPosition]->getRow();
            for ($jPosition = 0;
                $jPosition < $matT->numberOfElements; )
            {
                $j = $matT->array[$jPosition]->getRow();
                $sum = 0;
                $k1 = $iPosition;
                $k2 = $jPosition;
                while ($k1 < $this->numberOfElements
                    && $this->array[$k1]->getRow() == $i
                    && $k2 < $matT->numberOfElements
                    && $matT->array[$k2]->getRow() == $j)
                {
                    if ($this->array[$k1]->getColumn() <
                        $matT->array[$k2]->getColumn())
                        ++$k1;
                    elseif ($this->array[$k1]->getColumn() >
                        $matT->array[$k2]->getColumn())
                        ++$k2;
                    else
                        $sum += $this->array[$k1++]->getDatum()
                            * $matT->array[$k2++]->getDatum();
                }
                if ($sum != 0)
                    $result[array($i, $j)] = $sum;
                while ($jPosition < $matT->numberOfElements &&
                    $matT->array[$jPosition]->getRow() == $j)
                    ++$jPosition;
            }
            while ($iPosition < $this->numberOfElements &&
                $this->array[$iPosition]->getRow() == $i)
                ++$iPosition;
        }
        return $result;
    }

    /**
     * Returns the sum of this matrix and the specified matrix.
     * This method is not implemented.
     *
     * @param object IMatrix $mat The specified matrix.
     * @return object SparseMatrixAsVector
     * The sum of this matrix and the specified matrix
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
        printf("SparseMatrixAsVector main program.\n");
        $status = 0;

        $mat = new SparseMatrixAsVector(6, 6, 6);
        AbstractMatrix::test($mat);
        AbstractMatrix::testTranspose($mat);
        $mat1 = new SparseMatrixAsVector(3, 3, 9);
        $mat2 = new SparseMatrixAsVector(3, 3, 9);
        AbstractMatrix::testTimes($mat1, $mat2);

        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(SparseMatrixAsVector::main(array_slice($argv, 1)));
}
?>
