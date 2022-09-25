<?php
/**
 * Smarty Internal Plugin Compile Rdelim
 * Compiles the {rdelim} tag
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

namespace Smarty\Internal\Compile;

use Smarty\Exception\SmartyCompilerException;
use Smarty\Internal\TemplateCompilerBase;

/**
 * Smarty Internal Plugin Compile Rdelim Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class RdelimCompile extends LdelimCompile
{
    /**
     * Compiles code for the {rdelim} tag
     * This tag does output the right delimiter.
     *
     * @param array                                 $args     array with attributes from parser
     * @param TemplateCompilerBase $compiler compiler object
     *
     * @return string compiled code
     * @throws SmartyCompilerException
     */
    public function compile($args, TemplateCompilerBase $compiler)
    {
        parent::compile($args, $compiler);
        return $compiler->smarty->right_delimiter;
    }
}
