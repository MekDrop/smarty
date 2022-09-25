<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method RegisterResource
 *
 * Smarty::registerResource() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class RegisterResourceMethod
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
     * @api  Smarty::registerResource()
     * @link https://www.smarty.net/docs/en/api.register.resource.tpl
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param string                                                          $name             name of resource type
     * @param \Smarty\Resource                                           $resource_handler instance of \Smarty\Resource
     *
     * @return \Smarty|\Smarty\Internal\Template
     */
    public function registerResource(\Smarty\Internal\TemplateBase $obj, $name, \Smarty\Resource $resource_handler)
    {
        $smarty = $obj->_getSmartyObj();
        $smarty->registered_resources[ $name ] = $resource_handler;
        return $obj;
    }
}
