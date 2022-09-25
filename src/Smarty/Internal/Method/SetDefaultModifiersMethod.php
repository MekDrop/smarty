<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

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
     * @param TemplateBase|Template|Smarty $obj
     * @param array|string $modifiers modifier or list of modifiers to set
     *
     * @return Smarty|Template
     *
     * @api Smarty::setDefaultModifiers()
     */
    public function setDefaultModifiers(TemplateBase $obj, $modifiers)
    {
        $smarty = $obj->_getSmartyObj();
        $smarty->default_modifiers = (array)$modifiers;
        return $obj;
    }
}
