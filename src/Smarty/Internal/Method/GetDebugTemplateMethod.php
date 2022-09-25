<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method GetDebugTemplate
 *
 * Smarty::getDebugTemplate() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class GetDebugTemplateMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * return name of debugging template
     *
     * @api Smarty::getDebugTemplate()
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     *
     * @return string
     */
    public function getDebugTemplate(\Smarty\Internal\TemplateBase $obj)
    {
        $smarty = $obj->_getSmartyObj();
        return $smarty->debug_tpl;
    }
}
