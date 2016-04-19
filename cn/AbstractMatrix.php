<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: AbstractMatrix.php,v 1.11 2005/12/09 01:11:03 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/AbstractObject.php';
require_once 'Opus11/IMatrix.php';

//{
/**
 * Abstract base class from which all matrix classes are derived.
 *
 * @package Opus11
 */
abstract class AbstractMatrix
    extends AbstractObject
    implements IMatrix
{
    /**
     * @var integer The number of rows.
     */
    protected $numRows = 0;
    /**
     * @var integer The number of columns.
     */
    protected $numCols = 0;

//!    // ...
//!}
//}>a

    /**
     * Constructs an AbstractMatrix with the given number of rows and columns.
     *
     * @param integer $numRows The number of rows.
     * @param integer $numCols The number of columns.
     */
    public function __construct($numRows, $numCols)
    {
        parent::__construct();
        $this->numRows = $numRows;
        $this->numCols = $numCols;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Rows getter.
     *
     * @return integer The number of rows.
     */
    public function getNumRows()
    {
        return $this->numRows;
    }

    /**
     * Columns getter.
     *
     * @return integer The number of columns.
     */
    public function getNumCols()
    {
        return $this->numCols;
    }

    /**
     * Returns a textual representation of this matrix.
     *
     * @return string A string.
     */
    public function __toString()
    {
        $s = '';
        for ($i = 0; $i < $this->numRows; ++$i)
        {
            for ($j = 0; $j < $this->numCols; ++$j)
            {
                $s .= str($this->offsetGet(array($i, $j))) . ' ';
            }
            $s .= "\n";
        }
        return $s;
    }

    /**
     * Matrix test program.
     *
     * @param object IMatrix $mat The matrix to test.
     */
    public static function test(IMatrix $mat)
    {
        printf("Matrix test program.\n");
        try
        {
            $k = 0;
            for ($i = 0; $i < $mat->getNumRows(); ++$i)
            {
                for ($j = 0; $j < $mat->getNumCols(); ++$j)
                {
                    $mat[array($i, $j)] = $k++;
                }
            }
            printf("%s\n", str($mat));
            $mat = $mat->plus($mat);
            printf("%s\n", str($mat));
        }
        catch (Exception $e)
        {
            printf("Caught %s\n", $e->getMessage());
        }
    }

    /**
     * Matrix transpose test program.
     *
     * @param object IMatrix $mat The matrix to test.
     */
    public static function testTranspose(IMatrix $mat)
    {
        printf("Matrix transpose test program.\n");
        try
        {
            $mat[array(0, 0)] = 31;
            $mat[array(0, 2)] = 41;
            $mat[array(0, 3)] = 59;
            $mat[array(1, 1)] = 26;
            $mat[array(2, 3)] = 53;
            $mat[array(2, 4)] = 58;
            $mat[array(4, 2)] = 97;
            $mat[array(5, 1)] = 93;
            $mat[array(5, 5)] = 23;
            printf("%s\n", str($mat));
            $mat[array(2, 4)] = 0;
            $mat[array(5, 3)] = 0;
            $mat = $mat->getTranspose();
            printf("%s\n", str($mat));
        }
        catch (Exception $e)
        {
            printf("Caught %s\n", $e->getMessage());
        }
    }

    /**
     * Matrix multiply test program.
     *
     * @param object IMatrix $mat1 A matrix to test.
     * @param object IMatrix $mat2 A matrix to test.
     */
    public static function testTimes(IMatrix $mat1, IMatrix $mat2)
    {
        try
        {
            printf("Matrix multiply test program.\n");
            $mat1[array(0, 0)] = 1;
            $mat1[array(0, 1)] = 2;
            $mat1[array(0, 2)] = 3;
            $mat2[array(0, 0)] = 1;
            $mat2[array(1, 0)] = 2;
            $mat2[array(2, 0)] = 3;
            printf("%s\n", str($mat1));
            printf("%s\n", str($mat2));
            $mat1 = $mat2->times($mat1);
            printf("%s\n", str($mat1));
        }
        catch (Exception $e)
        {
            printf("Caught %s\n", $e->getMessage());
        }
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("AbstractMatrix main program.\n");
        $status = 0;
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(AbstractMatrix::main(array_slice($argv, 1)));
}
?>
