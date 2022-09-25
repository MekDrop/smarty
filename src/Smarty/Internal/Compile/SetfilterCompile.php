<?php
/**
 * Smarty Internal Plugin Compile Setfilter
 * Compiles code for setfilter tag
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

namespace Smarty\Internal\Compile;

/**
 * Smarty Internal Plugin Compile Setfilter Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class SetfilterCompile extends \Smarty\Internal\CompileBase
{
    /**
     * Compiles code for setfilter tag
     *
     * @param array                                 $args      array with attributes from parser
     * @param \Smarty\Internal\TemplateCompilerBase $compiler  compiler object
     * @param array                                 $parameter array with compilation parameter
     *
     * @return string compiled code
     */
    public function compile($args, \Smarty\Internal\TemplateCompilerBase $compiler, $parameter)
    {
        $compiler->variable_filter_stack[] = $compiler->variable_filters;
        $compiler->variable_filters = $parameter[ 'modifier_list' ];
        // this tag does not return compiled code
        $compiler->has_code = false;
        return true;
    }
}

/**
 * Smarty Internal Plugin Compile Setfilterclose Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class SetfiltercloseCompile extends \Smarty\Internal\CompileBase
{
    /**
     * Compiles code for the {/setfilter} tag
     * This tag does not generate compiled output. It resets variable filter.
     *
     * @param array                                 $args     array with attributes from parser
     * @param \Smarty\Internal\TemplateCompilerBase $compiler compiler object
     *
     * @return string compiled code
     */
    public function compile($args, \Smarty\Internal\TemplateCompilerBase $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        // reset variable filter to previous state
        if (count($compiler->variable_filter_stack)) {
            $compiler->variable_filters = array_pop($compiler->variable_filter_stack);
        } else {
            $compiler->variable_filters = array();
        }
        // this tag does not return compiled code
        $compiler->has_code = false;
        return true;
    }
}
