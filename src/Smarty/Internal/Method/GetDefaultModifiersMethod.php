<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

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
     * @param TemplateBase|Template|Smarty $obj
     *
     * @return array list of default modifiers
     *
     * @api Smarty::getDefaultModifiers()
     */
    public function getDefaultModifiers(TemplateBase $obj)
    {
        $smarty = $obj->_getSmartyObj();
        return $smarty->default_modifiers;
    }
}
