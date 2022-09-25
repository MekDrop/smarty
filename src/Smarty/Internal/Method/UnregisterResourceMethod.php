<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method UnregisterResource
 *
 * Smarty::unregisterResource() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class UnregisterResourceMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Registers a resource to fetch a template
     *
     * @api  Smarty::unregisterResource()
     * @link https://www.smarty.net/docs/en/api.unregister.resource.tpl
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param string                                                          $type name of resource type
     *
     * @return \Smarty|\Smarty\Internal\Template
     */
    public function unregisterResource(\Smarty\Internal\TemplateBase $obj, $type)
    {
        $smarty = $obj->_getSmartyObj();
        if (isset($smarty->registered_resources[ $type ])) {
            unset($smarty->registered_resources[ $type ]);
        }
        return $obj;
    }
}
