<?php

namespace Smarty\Internal\Method;

use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

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
     * @param TemplateBase|Template|\Smarty $obj
     * @param array|string $modifiers modifier or list of modifiers to add
     *
     * @return \Smarty|Template
     * @api Smarty::addDefaultModifiers()
     */
    public function addDefaultModifiers(TemplateBase $obj, $modifiers)
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
