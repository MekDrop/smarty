<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsFilter
 */
/**
 * Smarty htmlspecialchars variablefilter plugin
 *
 * @param string                    $source input string
 * @param \Smarty\Internal\Template $template
 *
 * @return string filtered output
 */
function smarty_variablefilter_htmlspecialchars($source, \Smarty\Internal\Template $template)
{
    return htmlspecialchars($source, ENT_QUOTES, Smarty::$_CHARSET);
}
