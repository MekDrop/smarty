<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method GetDefaultModifiers
 *
 * Smarty::getDefaultModifiers() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class GetDefaultModifiersMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Get default modifiers
     *
     * @api Smarty::getDefaultModifiers()
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     *
     * @return array list of default modifiers
     */
    public function getDefaultModifiers(\Smarty\Internal\TemplateBase $obj)
    {
        $smarty = $obj->_getSmartyObj();
        return $smarty->default_modifiers;
    }
}
