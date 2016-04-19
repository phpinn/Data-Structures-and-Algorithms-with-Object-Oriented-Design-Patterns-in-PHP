<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: BoxedString.php,v 1.12 2005/12/09 01:11:08 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/Box.php';

//{
/**
 * Represents a string.
 *
 * @package Opus11
 */
class BoxedString
    extends Box
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a BoxedString with the given value.
     *
     * @param string $value A value.
     */
    public function __construct($value)
    {
        parent::__construct(strval($value));
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Value setter.
     *
     * @param string $value A value.
     */
    public function setValue($value)
    {
        $this->value = strval($value);
    }

    /**
     * Compares this object with the given object.
     * This object and the given object are instances of the same class.
     *
     * @param object IComparable $obj The given object.
     * @return integer A number less than zero
     * if this object is less than the given object,
     * zero if this object equals the given object, and
     * a number greater than zero
     * if this object is greater than the given object.
     */
    protected function compareTo(IComparable $obj)
    {
        return strcmp($this->value, $obj->value);
    }
//}>a

//{
    const SHIFT = 6;
    const MASK = 0xfc000000;

    public function getHashCode()
    {
        $result = 0;
        for ($i = 0; $i < strlen($this->value); ++$i)
        {
            $result = ($result & self::MASK) ^
                ($result << self::SHIFT) ^ ord($this->value[$i]);
        }
        return $result;
    }
//}>b

    public static function testHash()
    {
        printf("String hash test program.\n");
        printf("ett=0%o\n", hash(new BoxedString("ett")));
        printf("tva=0%o\n", hash(new BoxedString("tva")));
        printf("tre=0%o\n", hash(new BoxedString("tre")));
        printf("fyra=0%o\n", hash(new BoxedString("fyra")));
        printf("fem=0%o\n", hash(new BoxedString("fem")));
        printf("sex=0%o\n", hash(new BoxedString("sex")));
        printf("sju=0%o\n", hash(new BoxedString("sju")));
        printf("atta=0%o\n", hash(new BoxedString("atta")));
        printf("nio=0%o\n", hash(new BoxedString("nio")));
        printf("tio=0%o\n", hash(new BoxedString("tio")));
        printf("elva=0%o\n", hash(new BoxedString("elva")));
        printf("tolv=0%o\n", hash(new BoxedString("tolv")));
        printf("abcdefghijklmnopqrstuvwxy=0%o\n",
                hash(new BoxedString("abcdefghijklmnopqrstuvwxyz")));
        printf("ece.uwaterloo.ca=0%o\n",
            hash(new BoxedString("ece.uwaterloo.ca")));
        printf("cs.uwaterloo.ca=0%o\n",
            hash(new BoxedString("cs.uwaterloo.ca")));
        printf("un=0%o\n", hash(new BoxedString("un")));
        printf("deux=0%o\n", hash(new BoxedString("deux")));
        printf("trois=0%o\n", hash(new BoxedString("trois")));
        printf("quatre=0%o\n", hash(new BoxedString("quatre")));
        printf("cinq=0%o\n", hash(new BoxedString("cinq")));
        printf("six=0%o\n", hash(new BoxedString("six")));
        printf("sept=0%o\n", hash(new BoxedString("sept")));
        printf("huit=0%o\n", hash(new BoxedString("huit")));
        printf("neuf=0%o\n", hash(new BoxedString("neuf")));
        printf("dix=0%o\n", hash(new BoxedString("dix")));
        printf("onze=0%o\n", hash(new BoxedString("onze")));
        printf("douze=0%o\n", hash(new BoxedString("douze")));
    }

    /**
     * Main program.
     *
     * @param array $args Command-line arguments.
     * @return integer Zero on success; non-zero on failure.
     */
    public static function main($args)
    {
        printf("BoxedString main program.\n");
        $status = 0;
        $s1 = new BoxedString('s1');
        printf("s1 = %s\n", str($s1));
        $s2 = new BoxedString('s2');
        printf("s2 = %s\n", str($s2));
        printf("s1 < s2 = %s\n", str(lt($s1, $s2)));
        printf("hash(s1) = %d\n", hash($s1));
        printf("hash(s2) = %d\n", hash($s2));
        BoxedString::testHash();
        return $status;
    }
}

if (realpath($argv[0]) == realpath(__FILE__))
{
    exit(BoxedString::main(array_slice($argv, 1)));
}
?>
