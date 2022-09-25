<?php

namespace Smarty\Internal\Method;

use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

/**
 * Smarty Method UnregisterCacheResource
 *
 * Smarty::unregisterCacheResource() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class UnregisterCacheResourceMethod
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
     * @param TemplateBase|Template|\Smarty $obj
     * @param $name
     *
     * @return \Smarty|Template
     *
     * @link https://www.smarty.net/docs/en/api.unregister.cacheresource.tpl
     * @api  Smarty::unregisterCacheResource()
     */
    public function unregisterCacheResource(TemplateBase $obj, $name)
    {
        $smarty = $obj->_getSmartyObj();
        if (isset($smarty->registered_cache_resources[ $name ])) {
            unset($smarty->registered_cache_resources[ $name ]);
        }
        return $obj;
    }
}
