<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method AddDefaultModifiers
 *
 * Smarty::addDefaultModifiers() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class AddDefaultModifiersMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Add default modifiers
     *
     * @api Smarty::addDefaultModifiers()
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param array|string                                                    $modifiers modifier or list of modifiers
     *                                                                                   to add
     *
     * @return \Smarty|\Smarty\Internal\Template
     */
    public function addDefaultModifiers(\Smarty\Internal\TemplateBase $obj, $modifiers)
    {
        $smarty = $obj->_getSmartyObj();
        if (is_array($modifiers)) {
            $smarty->default_modifiers = array_merge($smarty->default_modifiers, $modifiers);
        } else {
            $smarty->default_modifiers[] = $modifiers;
        }
        return $obj;
    }
}
