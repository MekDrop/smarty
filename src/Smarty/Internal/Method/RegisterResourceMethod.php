<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;
use Smarty\Resource;

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
     * @param TemplateBase|Template|Smarty $obj
     * @param string                                                          $name name of resource type
     * @param Resource                                           $resource_handler instance of \Smarty\Resource
     *
     * @return Smarty|Template
     *
     * @api  Smarty::registerResource()
     * @link https://www.smarty.net/docs/en/api.register.resource.tpl
     *
     */
    public function registerResource(TemplateBase $obj, $name, Resource $resource_handler)
    {
        $smarty = $obj->_getSmartyObj();
        $smarty->registered_resources[ $name ] = $resource_handler;
        return $obj;
    }
}
