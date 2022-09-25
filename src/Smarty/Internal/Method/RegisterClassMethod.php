<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method RegisterClass
 *
 * Smarty::registerClass() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class RegisterClassMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Registers static classes to be used in templates
     *
     * @api  Smarty::registerClass()
     * @link https://www.smarty.net/docs/en/api.register.class.tpl
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param string                                                          $class_name
     * @param string                                                          $class_impl the referenced PHP class to
     *                                                                                    register
     *
     * @return \Smarty|\Smarty\Internal\Template
     * @throws \SmartyException
     */
    public function registerClass(\Smarty\Internal\TemplateBase $obj, $class_name, $class_impl)
    {
        $smarty = $obj->_getSmartyObj();
        // test if exists
        if (!class_exists($class_impl)) {
            throw new \SmartyException("Undefined class '$class_impl' in register template class");
        }
        // register the class
        $smarty->registered_classes[ $class_name ] = $class_impl;
        return $obj;
    }
}
