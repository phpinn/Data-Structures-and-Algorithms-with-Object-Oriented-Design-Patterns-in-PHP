<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ISparseMatrix.php,v 1.5 2005/11/27 23:32:33 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/IMatrix.php';

//{
/**
 * Interface implemented by all sparse matrix classes.
 *
 * @package Opus11
 */
interface ISparseMatrix
    extends IMatrix
{
    /**
     * Stores a zero value in this matrix at the given indices.
     *
     * @param array $indices A set of indices.
     */
    public abstract function putZero($indices);
}
//}>a
?>
