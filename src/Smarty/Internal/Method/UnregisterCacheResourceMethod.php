<?php

namespace Smarty\Internal\Method;

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
     * @api  Smarty::unregisterCacheResource()
     * @link https://www.smarty.net/docs/en/api.unregister.cacheresource.tpl
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param                                                                 $name
     *
     * @return \Smarty|\Smarty\Internal\Template
     */
    public function unregisterCacheResource(\Smarty\Internal\TemplateBase $obj, $name)
    {
        $smarty = $obj->_getSmartyObj();
        if (isset($smarty->registered_cache_resources[ $name ])) {
            unset($smarty->registered_cache_resources[ $name ]);
        }
        return $obj;
    }
}
