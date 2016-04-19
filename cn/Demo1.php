<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: Demo1.php,v 1.10 2005/12/09 01:11:09 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/DenseMatrix.php';
require_once 'Opus11/SparseMatrixAsArray.php';
require_once 'Opus11/SparseMatrixAsVector.php';
require_once 'Opus11/SparseMatrixAsLinkedList.php';

/**
 * Provides demonstration program number 1.
 *
 * @package Opus11
 */
class Demo1
{
    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer $Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("Demonstration program number 1.\n");
        $status = 0;
        DenseMatrix::main($args);
        SparseMatrixAsArray::main($args);
        SparseMatrixAsVector::main($args);
        SparseMatrixAsLinkedList::main($args);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(Demo1::main(array_slice($argv, 1)));
}
?>
