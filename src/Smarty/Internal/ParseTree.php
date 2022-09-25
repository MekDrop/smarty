<?php
/**
 * Smarty Internal Plugin Templateparser Parsetree
 * These are classes to build parsetree in the template parser
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Thue Kristensen
 * @author     Uwe Tews
 */

namespace Smarty\Internal;

/**
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */
abstract class ParseTree
{
    /**
     * Buffer content
     *
     * @var mixed
     */
    public $data;

    /**
     * Subtree array
     *
     * @var array
     */
    public $subtrees = array();

    /**
     * Return buffer
     *
     * @param \Smarty\Internal\Templateparser $parser
     *
     * @return string buffer content
     */
    abstract public function to_smarty_php(\Smarty\Internal\Templateparser $parser);

    /**
     * Template data object destructor
     */
    public function __destruct()
    {
        $this->data = null;
        $this->subtrees = null;
    }
}
