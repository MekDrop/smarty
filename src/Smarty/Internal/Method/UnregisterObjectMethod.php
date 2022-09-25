<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method UnregisterObject
 *
 * Smarty::unregisterObject() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class UnregisterObjectMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Registers plugin to be used in templates
     *
     * @api  Smarty::unregisterObject()
     * @link https://www.smarty.net/docs/en/api.unregister.object.tpl
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param string                                                          $object_name name of object
     *
     * @return \Smarty|\Smarty\Internal\Template
     */
    public function unregisterObject(\Smarty\Internal\TemplateBase $obj, $object_name)
    {
        $smarty = $obj->_getSmartyObj();
        if (isset($smarty->registered_objects[ $object_name ])) {
            unset($smarty->registered_objects[ $object_name ]);
        }
        return $obj;
    }
}
