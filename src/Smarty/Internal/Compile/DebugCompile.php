<?php
/**
 * Smarty Internal Plugin Compile Debug
 * Compiles the {debug} tag.
 * It opens a window the the Smarty Debugging Console.
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

namespace Smarty\Internal\Compile;

use Smarty\Internal\CompileBase;
use Smarty\Internal\Debug;

/**
 * Smarty Internal Plugin Compile Debug Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class DebugCompile extends CompileBase
{
    /**
     * Compiles code for the {debug} tag
     *
     * @param array  $args     array with attributes from parser
     * @param object $compiler compiler object
     *
     * @return string compiled code
     */
    public function compile($args, $compiler)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        // compile always as nocache
        $compiler->tag_nocache = true;
        // display debug template
        $_output =
            "<?php \$_smarty_debug = new \\".Debug::class.";\n \$_smarty_debug->display_debug(\$_smarty_tpl);\n";
        $_output .= "unset(\$_smarty_debug);\n?>";
        return $_output;
    }
}
