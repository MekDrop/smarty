<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method RegisterCacheResource
 *
 * Smarty::registerCacheResource() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class RegisterCacheResourceMethod
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
     * @api  Smarty::registerCacheResource()
     * @link https://www.smarty.net/docs/en/api.register.cacheresource.tpl
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param string                                                          $name name of resource type
     * @param \Smarty\CacheResource                                           $resource_handler
     *
     * @return \Smarty|\Smarty\Internal\Template
     */
    public function registerCacheResource(
        \Smarty\Internal\TemplateBase $obj,
        $name,
        \Smarty\CacheResource $resource_handler
    ) {
        $smarty = $obj->_getSmartyObj();
        $smarty->registered_cache_resources[ $name ] = $resource_handler;
        return $obj;
    }
}
