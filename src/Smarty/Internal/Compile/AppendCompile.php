<?php
/**
 * Smarty Internal Plugin Compile Append
 * Compiles the {append} tag
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

namespace Smarty\Internal\Compile;

use Smarty\Exception\SmartyCompilerException;
use Smarty\Internal\TemplateCompilerBase;

/**
 * Smarty Internal Plugin Compile Append Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class AppendCompile extends AssignCompile
{
    /**
     * Compiles code for the {append} tag
     *
     * @param array                                 $args      array with attributes from parser
     * @param TemplateCompilerBase $compiler  compiler object
     * @param array                                 $parameter array with compilation parameter
     *
     * @return string compiled code
     * @throws SmartyCompilerException
     */
    public function compile($args, TemplateCompilerBase $compiler, $parameter)
    {
        // the following must be assigned at runtime because it will be overwritten in parent class
        $this->required_attributes = array('var', 'value');
        $this->shorttag_order = array('var', 'value');
        $this->optional_attributes = array('scope', 'index');
        $this->mapCache = array();
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        // map to compile assign attributes
        if (isset($_attr[ 'index' ])) {
            $_params[ 'smarty_internal_index' ] = '[' . $_attr[ 'index' ] . ']';
            unset($_attr[ 'index' ]);
        } else {
            $_params[ 'smarty_internal_index' ] = '[]';
        }
        $_new_attr = array();
        foreach ($_attr as $key => $value) {
            $_new_attr[] = array($key => $value);
        }
        // call compile assign
        return parent::compile($_new_attr, $compiler, $_params);
    }
}
