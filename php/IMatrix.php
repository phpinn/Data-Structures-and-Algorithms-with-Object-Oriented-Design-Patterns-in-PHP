<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: IMatrix.php,v 1.7 2005/11/27 23:32:32 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IObject.php';

//{
/**
 * Interface implemented by all matrix classes.
 *
 * @package Opus11
 */
interface IMatrix
    extends IObject, ArrayAccess
{
    /**
     * Rows getter.
     *
     * @return integer The number of rows in this matrix.
     */
    public abstract function getNumRows();
    /**
     * Columns getter.
     *
     * @return integer The number of columns in this matrix.
     */
    public abstract function getNumCols();
    /**
     * Returns the transpose of this matrix.
     *
     * @return object IMatrix The transpose.
     */
    public abstract function getTranspose();
    /**
     * Returns the sum of this matrix and the given matrix.
     *
     * @param object IMatrix $matrix A matrix.
     * @return object IMatrix The sum.
     */
    public abstract function plus(IMatrix $matrix);
    /**
     * Returns the product of this matrix and the given matrix.
     *
     * @param object IMatrix $matrix A matrix.
     * @return object IMatrix The product.
     */
    public abstract function times(IMatrix $matrix);
}
//}>a
?>
