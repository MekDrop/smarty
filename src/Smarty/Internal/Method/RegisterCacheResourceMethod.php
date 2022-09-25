<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\CacheResource;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

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
     * @param TemplateBase|Template|Smarty $obj
     * @param string                                                          $name name of resource type
     * @param CacheResource                                           $resource_handler
     *
     * @return Smarty|Template
     *
     * @api  Smarty::registerCacheResource()
     * @link https://www.smarty.net/docs/en/api.register.cacheresource.tpl
     *
     */
    public function registerCacheResource(
        TemplateBase $obj,
        $name,
        CacheResource $resource_handler
    ) {
        $smarty = $obj->_getSmartyObj();
        $smarty->registered_cache_resources[ $name ] = $resource_handler;
        return $obj;
    }
}
