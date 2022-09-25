<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

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
     * @param TemplateBase|Template|Smarty $obj
     * @param string                                                          $object_name name of object
     *
     * @return Smarty|Template
     *
     * @link https://www.smarty.net/docs/en/api.unregister.object.tpl
     * @api  Smarty::unregisterObject()
     */
    public function unregisterObject(TemplateBase $obj, $object_name)
    {
        $smarty = $obj->_getSmartyObj();
        if (isset($smarty->registered_objects[ $object_name ])) {
            unset($smarty->registered_objects[ $object_name ]);
        }
        return $obj;
    }
}
