<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method SetDebugTemplate
 *
 * Smarty::setDebugTemplate() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class SetDebugTemplateMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * set the debug template
     *
     * @api Smarty::setDebugTemplate()
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param string                                                          $tpl_name
     *
     * @return \Smarty|\Smarty\Internal\Template
     * @throws \SmartyException if file is not readable
     */
    public function setDebugTemplate(\Smarty\Internal\TemplateBase $obj, $tpl_name)
    {
        $smarty = $obj->_getSmartyObj();
        if (!is_readable($tpl_name)) {
            throw new \SmartyException("Unknown file '{$tpl_name}'");
        }
        $smarty->debug_tpl = $tpl_name;
        return $obj;
    }
}
