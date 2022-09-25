<?php
/**
 * Smarty plugin getvar
 *
 * @package    Smarty
 * @subpackage PHPunitPlugin
 */

use Smarty\Internal\Template;

/**
 * Smarty {getvar}
 *
 * @param array  $params   parameter array
 * @param object $template template object
 *
 * @return string
 */
function smarty_function_getvar($params, Template $template)
{
    if (isset($params[ 'assign' ])) {
        $template->assign($params[ 'assign' ], $template->getTemplateVars($params[ 'var' ]));
    } else {
        return $template->getTemplateVars($params[ 'var' ]);
    }
}
