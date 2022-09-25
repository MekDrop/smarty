<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsModifierCompiler
 */

use Smarty\Exception\SmartyException;
use Smarty\Internal\TemplateCompilerBase;

/**
 * Smarty wordwrap modifier plugin
 * Type:     modifier
 * Name:     wordwrap
 * Purpose:  wrap a string of text at a given length
 *
 * @link   https://www.smarty.net/manual/en/language.modifier.wordwrap.php wordwrap (Smarty online manual)
 * @author Uwe Tews
 *
 * @param array                                 $params parameters
 * @param TemplateCompilerBase $compiler
 *
 * @return string with compiled code
 * @throws SmartyException
 */
function smarty_modifiercompiler_wordwrap($params, TemplateCompilerBase $compiler)
{
    if (!isset($params[ 1 ])) {
        $params[ 1 ] = 80;
    }
    if (!isset($params[ 2 ])) {
        $params[ 2 ] = '"\n"';
    }
    if (!isset($params[ 3 ])) {
        $params[ 3 ] = 'false';
    }
    $function = 'wordwrap';
    if (Smarty::$_MBSTRING) {
        $function = $compiler->getPlugin('mb_wordwrap', 'modifier');
    }
    return $function . '(' . $params[ 0 ] . ',' . $params[ 1 ] . ',' . $params[ 2 ] . ',' . $params[ 3 ] . ')';
}
