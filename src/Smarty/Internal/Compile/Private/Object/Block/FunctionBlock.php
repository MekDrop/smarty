<?php
/**
 * Smarty Internal Plugin Compile Object Block Function
 * Compiles code for registered objects as block function
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

namespace Smarty\Internal\Compile\Private\Object\Block;

use Smarty\Internal\Compile\Private\Block\PluginBlock;

/**
 * Smarty Internal Plugin Compile Object Block Function Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class FunctionBlock extends PluginBlock
{
    /**
     * Setup callback and parameter array
     *
     * @param \Smarty\Internal\TemplateCompilerBase $compiler
     * @param array                                 $_attr attributes
     * @param string                                $tag
     * @param string                                $method
     *
     * @return array
     */
    public function setup(\Smarty\Internal\TemplateCompilerBase $compiler, $_attr, $tag, $method)
    {
        $_paramsArray = array();
        foreach ($_attr as $_key => $_value) {
            if (is_int($_key)) {
                $_paramsArray[] = "$_key=>$_value";
            } else {
                $_paramsArray[] = "'$_key'=>$_value";
            }
        }
        $callback = array("\$_smarty_tpl->smarty->registered_objects['{$tag}'][0]", "->{$method}");
        return array($callback, $_paramsArray, "array(\$_block_plugin{$this->nesting}, '{$method}')");
    }
}
