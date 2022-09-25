<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Exception\SmartyException;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

/**
 * Smarty Method GetRegisteredObject
 *
 * Smarty::getRegisteredObject() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class GetRegisteredObjectMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * return a reference to a registered object
     *
     * @param TemplateBase|Template|Smarty $obj
     * @param string                                                          $object_name object name
     *
     * @return object
     * @throws SmartyException if no such object is found
     *
     * @api  Smarty::getRegisteredObject()
     * @link https://www.smarty.net/docs/en/api.get.registered.object.tpl
     */
    public function getRegisteredObject(TemplateBase $obj, $object_name)
    {
        $smarty = $obj->_getSmartyObj();
        if (!isset($smarty->registered_objects[ $object_name ])) {
            throw new SmartyException("'$object_name' is not a registered object");
        }
        if (!is_object($smarty->registered_objects[ $object_name ][ 0 ])) {
            throw new SmartyException("registered '$object_name' is not an object");
        }
        return $smarty->registered_objects[ $object_name ][ 0 ];
    }
}
