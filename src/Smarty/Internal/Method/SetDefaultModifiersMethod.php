<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method SetDefaultModifiers
 *
 * Smarty::setDefaultModifiers() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class SetDefaultModifiersMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Set default modifiers
     *
     * @api Smarty::setDefaultModifiers()
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param array|string                                                    $modifiers modifier or list of modifiers
     *                                                                                   to set
     *
     * @return \Smarty|\Smarty\Internal\Template
     */
    public function setDefaultModifiers(\Smarty\Internal\TemplateBase $obj, $modifiers)
    {
        $smarty = $obj->_getSmartyObj();
        $smarty->default_modifiers = (array)$modifiers;
        return $obj;
    }
}
