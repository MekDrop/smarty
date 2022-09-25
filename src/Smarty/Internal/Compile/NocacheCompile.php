<?php
/**
 * Smarty Internal Plugin Compile Nocache
 * Compiles the {nocache} {/nocache} tags.
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

namespace Smarty\Internal\Compile;

/**
 * Smarty Internal Plugin Compile Nocache Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class NocacheCompile extends \Smarty\Internal\CompileBase
{
    /**
     * Array of names of valid option flags
     *
     * @var array
     */
    public $option_flags = array();

    /**
     * Compiles code for the {nocache} tag
     * This tag does not generate compiled output. It only sets a compiler flag.
     *
     * @param array                                 $args     array with attributes from parser
     * @param \Smarty\Internal\TemplateCompilerBase $compiler compiler object
     *
     * @return bool
     */
    public function compile($args, \Smarty\Internal\TemplateCompilerBase $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        $this->openTag($compiler, 'nocache', array($compiler->nocache));
        // enter nocache mode
        $compiler->nocache = true;
        // this tag does not return compiled code
        $compiler->has_code = false;
        return true;
    }
}

/**
 * Smarty Internal Plugin Compile Nocacheclose Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class Nocacheclose extends \Smarty\Internal\CompileBase
{
    /**
     * Compiles code for the {/nocache} tag
     * This tag does not generate compiled output. It only sets a compiler flag.
     *
     * @param array                                 $args     array with attributes from parser
     * @param \Smarty\Internal\TemplateCompilerBase $compiler compiler object
     *
     * @return bool
     */
    public function compile($args, \Smarty\Internal\TemplateCompilerBase $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        // leave nocache mode
        list($compiler->nocache) = $this->closeTag($compiler, array('nocache'));
        // this tag does not return compiled code
        $compiler->has_code = false;
        return true;
    }
}
