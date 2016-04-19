<?php
/**
 * @copyright Copyright (c) 2005 by Bruno R. Preiss, P.Eng.
 *
 * @author $Author: brpreiss $
 * @version $Id: ExpressionTree.php,v 1.4 2005/12/09 01:11:11 brpreiss Exp $
 * @package Opus11
 */

/**
 */
require_once 'Opus11/BinaryTree.php';
require_once 'Opus11/StackAsLinkedList.php';
require_once 'Opus11/AbstractPrePostVisitor.php';

//{
/**
 * Visitor that prints an expression tree in infix notation.
 *
 * @package Opus11
 */
class ExpressionTree_InfixVisitor
    extends AbstractPrePostVisitor
{
    /**
     * @var resource The output stream.
     */
    protected $stream = NULL;

    /**
     * Constructs an ExpressionTree_InfixVisitor that prints
     * an expression tree on the given output stream.
     *
     * @param resource $stream An output stream.
     */
    public function __construct($stream)
    {
        parent::__construct();
        $this->stream = $stream;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->stream = NULL;
        parent::__destruct();
    }

    /**
     * Prints a left parenthesis.
     *
     * @param object IObject $obj Ignored.
     */
    public function preVisit(IObject $obj)
    {
        fprintf($this->stream, '(');
    }

    /**
     * Prints the given object.
     *
     * @param object IObject $obj An object.
     */
    public function inVisit(IObject $obj)
    {
        fprintf($this->stream, "%s", str($obj));
    }

    /**
     * Prints a right parenthesis.
     *
     * @param object IObject $obj Ignored.
     */
    public function postVisit(IObject $obj)
    {
        fprintf($this->stream, ')');
    }
}
//}>c

//{
/**
 * Represents a binary expression as a binary tree.
 *
 * @package Opus11
 */
class ExpressionTree
    extends BinaryTree
{
//}@head

//{
//!    // ...
//!}
//}@tail

//{
    /**
     * Constructs a ExpressionTree that consists
     * of a single (leaf) node with the specified label.
     *
     * @param string $c The label on this node.
     */
    public function __construct($c)
    {
        parent::__construct(new BoxedString($c));
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }
    
    /**
     * Parses a postfix expression read from the specified input stream
     * and constructs the corresponding expression tree.
     * The postfix expression consists of one-letter symbols,
     * one-digit numbers, +, -, * and /.
     *
     * @param resource $in The input stream.
     * @return object ExpressionTree An expression tree.
     */
    public static function parsePostfix($in)
    {
        $stack = new StackAsLinkedList();

        while (($c = fgetc($in)) != false)
        {
            if (ord('0') <= ord($c) && ord($c) <= ord('9') ||
                ord('a') <= ord($c) && ord($c) <= ord('z') ||
                ord('A') <= ord($c) && ord($c) <= ord('Z'))
            {
                $stack->push(new ExpressionTree($c));
            }
            elseif ($c == '+' || $c == '-' ||
                $c == '*' || $c =='/')
            {
                $result = new ExpressionTree($c);
                $result->attachRight($stack->pop());
                $result->attachLeft($stack->pop());
                $stack->push($result);
            }
        }
        return $stack->pop();
    }
//}>a

//{
    /**
     * Returns a string representation of this expression tree
     * using infix notation.
     *
     * @return string A string representation of this expression tree.
     */
    public function __toString()
    {
        $this->depthFirstTraversal(
            new ExpressionTree_InfixVisitor(STDOUT));
    }
//}>b
}
?>
