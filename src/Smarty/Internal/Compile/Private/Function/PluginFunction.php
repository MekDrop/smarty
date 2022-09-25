<?php
/**
 * Smarty Internal Plugin Compile Function Plugin
 * Compiles code for the execution of function plugin
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

namespace Smarty\Internal\Compile\Private;

/**
 * Smarty Internal Plugin Compile Function Plugin Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class PluginFunction extends \Smarty\Internal\CompileBase
{
    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see \Smarty\Internal\CompileBase
     */
    public $required_attributes = array();

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see \Smarty\Internal\CompileBase
     */
    public $optional_attributes = array('_any');

    /**
     * Compiles code for the execution of function plugin
     *
     * @param array                                 $args      array with attributes from parser
     * @param \Smarty\Internal\TemplateCompilerBase $compiler  compiler object
     * @param array                                 $parameter array with compilation parameter
     * @param string                                $tag       name of function plugin
     * @param string                                $function  PHP function name
     *
     * @return string compiled code
     * @throws \Smarty\Exception\SmartyCompilerException
     * @throws \Smarty\Exception\SmartyException
     */
    public function compile($args, \Smarty\Internal\TemplateCompilerBase $compiler, $parameter, $tag, $function)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        unset($_attr[ 'nocache' ]);
        // convert attributes into parameter array string
        $_paramsArray = array();
        foreach ($_attr as $_key => $_value) {
            if (is_int($_key)) {
                $_paramsArray[] = "$_key=>$_value";
            } else {
                $_paramsArray[] = "'$_key'=>$_value";
            }
        }
        $_params = 'array(' . implode(',', $_paramsArray) . ')';
        // compile code
        $output = "{$function}({$_params},\$_smarty_tpl)";
        if (!empty($parameter[ 'modifierlist' ])) {
            $output = $compiler->compileTag(
                'private_modifier',
                array(),
                array(
                    'modifierlist' => $parameter[ 'modifierlist' ],
                    'value'        => $output
                )
            );
        }
        $output = "<?php echo {$output};?>\n";
        return $output;
    }
}
