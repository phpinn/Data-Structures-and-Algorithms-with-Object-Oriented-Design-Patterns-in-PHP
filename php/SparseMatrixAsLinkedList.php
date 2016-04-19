<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: SparseMatrixAsLinkedList.php,v 1.6 2005/12/09 01:11:17 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractMatrix.php';
require_once 'Opus11/ISparseMatrix.php';
require_once 'Opus11/BasicArray.php';
require_once 'Opus11/LinkedList.php';
require_once 'Opus11/Exceptions.php';

/**
 * Data structure used to represent a matrix entry.
 *
 * @package Opus11
 */
class SparseMatrixAsLinkedList_Entry
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
 * Sparse matrix implemented using an array of linked lists.
 *
 * @package Opus11
 */
class SparseMatrixAsLinkedList
    extends AbstractMatrix
    implements ISparseMatrix
{
    /**
     * @var object BasicArray
     * An array of linked lists---one linked list for each row.
     */
    protected $lists = NULL;

    /**
     * Construct a <code>SparseMatrixAsLinkedLists</code>
     * with the specified dimensions.
     *
     * @param integer $numRows The number of rows.
     * @param integer $numCols The number of columns.
     */
    public function __construct($numRows, $numCols)
    {
        parent::__construct($numRows, $numCols);
        $this->lists = new BasicArray($numRows);
        for ($i = 0; $i < $this->numRows; ++$i)
            $this->lists[$i] = new LinkedList();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->lists = NULL;
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
        for ($ptr = $this->lists[$i]->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext ())
        {
            $entry = $ptr->getDatum();
            if ($entry->getColumn() == $j)
                return $entry->getDatum();
            if ($entry->getColumn() > $j)
                break;
        }
        return 0;
    }

    /**
     * Stores the specified value in this matrix at the specified indices.
     *
     * @param array $indices The indices.
     * @param mixed $datum The value to be stored.
     */
    public function offsetSet($indices, $datum)
    {
        if (!$this->offsetExists($indices))
            throw new IndexError();
        $i = $indices[0];
        $j = $indices[1];
        for ($ptr = $this->lists[$i]->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            $entry = $ptr->getDatum();
            if ($entry->getColumn() == $j)
            {
                $entry->setDatum($datum);
                return;
            }
            elseif ($entry->getColumn() > $j)
            {
                $ptr->insertBefore(new SparseMatrixAsLinkedList_Entry(
                    $i, $j, $datum));
                return;
            }
        }
        $this->lists[$i]->append(new SparseMatrixAsLinkedList_Entry (
            $i, $j, $datum));
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
     * @param array $indices The indices.
     * @param mixed $datum The value to be stored.
     */
    public function putZero($indices)
    {
        if (!$this->offsetExists($indices))
            throw new IndexError();
        $i = $indices[0];
        $j = $indices[1];
        for ($ptr = $this->lists[i]->getHead();
            $ptr !== NULL; $ptr = $ptr->getNext())
        {
            $entry = $ptr->getDatum();
            if ($entry->getColumn() == $j)
            {
                $this->lists[i]->extract($entry);
                return;
            }
        }
    }

    /**
     * Returns the transpose of this matrix.
     *
     * @return object SparseMatrixAsLinkedList The transpose of this matrix.
     */
    public function getTranspose()
    {
        $result = new SparseMatrixAsLinkedList(
            $this->numCols, $this->numRows);
        for ($i = 0; $i < $this->numCols; ++$i)
        {
            for ($ptr = $this->lists[$i]->getHead();
                $ptr !== NULL; $ptr = $ptr->getNext())
            {
                $entry = $ptr->getDatum();
                $result->lists[$entry->getColumn()]->append(
                    new SparseMatrixAsLinkedList_Entry(
                        $entry->getColumn(), $entry->getRow(),
                        $entry->getDatum()));
            }
        }
        return $result;
    }

    /**
     * Returns the product of this matrix and the specified matrix.
     * This method is not implemented.
     *
     * @param object IMatrix $mat The specified matrix.
     * @return object SparseMatrixAsLinkedList
     * The product of this matrix and the specified matrix
     * @exception MethodNotImplemented Always.
     */
    public function times(IMatrix $mat)
    {
        throw new MethodNotImplementedException();
    }

    /**
     * Returns the sum of this matrix and the specified matrix.
     * This method is not implemented.
     * @param object IMatrix $mat The specified matrix.
     * @return object SparseMatrixAsLinkedList
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
        printf("SparseMatrixAsLinkedList main program.\n");
        $status = 0;

        $mat = new SparseMatrixAsLinkedList(6, 6, 6);
        AbstractMatrix::test($mat);
        AbstractMatrix::testTranspose($mat);

        $mat1 = new SparseMatrixAsLinkedList(3, 3, 3);
        $mat2 = new SparseMatrixAsLinkedList(3, 3, 3);
        AbstractMatrix::testTimes($mat1, $mat2);

        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(SparseMatrixAsLinkedList::main(array_slice($argv, 1)));
}
?>
