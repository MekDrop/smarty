<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Exception\SmartyException;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

/**
 * Smarty Method RegisterObject
 *
 * Smarty::registerObject() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class RegisterObjectMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Registers object to be used in templates
     *
     * @param TemplateBase|Template|Smarty $obj
     * @param string                                                          $object_name
     * @param object                                                          $object                     the
     *                                                                                                    referenced
     *                                                                                                    PHP
     *                                                                                                    object
     *                                                                                                    to
     *                                                                                                    register
     *
     * @param array                                                           $allowed_methods_properties list of
     *                                                                                                    allowed
     *                                                                                                    methods
     *                                                                                                    (empty
     *                                                                                                    = all)
     *
     * @param bool                                                            $format                     smarty
     *                                                                                                    argument
     *                                                                                                    format,
     *                                                                                                    else
     *                                                                                                    traditional
     *
     * @param array                                                           $block_methods              list of
     *                                                                                                    block-methods
     *
     * @return Smarty|Template
     * @throws SmartyException
     *
     * @api  Smarty::registerObject()
     * @link https://www.smarty.net/docs/en/api.register.object.tpl
     */
    public function registerObject(
        TemplateBase $obj,
        $object_name,
        $object,
        $allowed_methods_properties = array(),
        $format = true,
        $block_methods = array()
    ) {
        $smarty = $obj->_getSmartyObj();
        // test if allowed methods callable
        if (!empty($allowed_methods_properties)) {
            foreach ((array)$allowed_methods_properties as $method) {
                if (!is_callable(array($object, $method)) && !property_exists($object, $method)) {
                    throw new SmartyException("Undefined method or property '$method' in registered object");
                }
            }
        }
        // test if block methods callable
        if (!empty($block_methods)) {
            foreach ((array)$block_methods as $method) {
                if (!is_callable(array($object, $method))) {
                    throw new SmartyException("Undefined method '$method' in registered object");
                }
            }
        }
        // register the object
        $smarty->registered_objects[ $object_name ] =
            array($object, (array)$allowed_methods_properties, (boolean)$format, (array)$block_methods);
        return $obj;
    }
}
