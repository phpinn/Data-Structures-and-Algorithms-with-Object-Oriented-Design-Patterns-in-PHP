<?php
/**
 * @copyright Copyright &copy; 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: OpenScatterTableV2.php,v 1.3 2005/12/09 01:11:14 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/OpenScatterTable.php';
require_once 'Opus11/Exceptions.php';

//{
/**
 * A open scatter table implemented using an array.
 *
 * @package Opus11
 */
class OpenScatterTableV2
    extends OpenScatterTable
{
//}@head

//{
//!    // ...
//!}
//}@tail

    /**
     * Constructs a OpenScatterTable with the given length.
     *
     * @param integer length The length of this hash table.
     */
    public function __construct($length = 0)
    {
        parent::__construct($length);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

//{
    /**
     * Withdraws the specified object from this open scatter table.
     *
     * @param object IComparable $obj The object to be withdrawn.
     */
    public function withdraw(IComparable $obj)
    {
        if ($this->count == 0)
            throw new ContainerEmptyException();
        $i = $this->findInstance($obj);
        if ($i < 0)
            throw new ArgumentError();
        for (;;)
        {
            $j = ($i + 1) % $this->getLength();
            while ($this->array[j]->state == self::OCCUPIED)
            {
                $h = $this->h($this->array[$j]->object);
                if (($h <= $i && $i < $j) ||
                    ($i < $j && $j < $h) ||
                    ($j < $h && $h <= $i))
                    break;
                $j = ($j + 1) % $this->getLength();
            }
            if ($this->array[$j]->state == self::_EMPTY)
                break;
            $this->array[$i]->state = $this->array[$j]->state;
            $this->array[$i]->object = $this->array[$j]->object;
            $i = $j;
        }
        $this->array[$i]->state = self::_EMPTY;
        $this->array[$i]->object = NULL;
        --$this->count;
    }
//}>a

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("OpenScatterTableV2 main program.\n");
        $status = 0;
        $hashTable = new OpenScatterTableV2(57);
        AbstractHashTable::test($hashTable);
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(OpenScatterTableV2::main(array_slice($argv, 1)));
}
?>
