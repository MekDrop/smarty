<?php
/**
 * Smarty Internal Plugin Templateparser Parse Tree
 * These are classes to build parse trees in the template parser
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Thue Kristensen
 * @author     Uwe Tews
 */

namespace Smarty\Internal\ParseTree;

use Smarty\Internal\ParseTree;
use Smarty\Internal\Templateparser;

/**
 * Code fragment inside a tag .
 *
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */
class CodeParseTree extends ParseTree
{
    /**
     * Create parse tree buffer for code fragment
     *
     * @param string $data content
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Return buffer content in parentheses
     *
     * @param Templateparser $parser
     *
     * @return string content
     */
    public function to_smarty_php(Templateparser $parser)
    {
        return sprintf('(%s)', $this->data);
    }
}
