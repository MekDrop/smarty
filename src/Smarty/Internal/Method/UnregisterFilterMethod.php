<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method UnregisterFilter
 *
 * Smarty::unregisterFilter() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class UnregisterFilterMethod extends RegisterFilterMethod
{
    /**
     * Unregisters a filter function
     *
     * @api  Smarty::unregisterFilter()
     *
     * @link https://www.smarty.net/docs/en/api.unregister.filter.tpl
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param string                                                          $type filter type
     * @param callback|string                                                 $callback
     *
     * @return \Smarty|\Smarty\Internal\Template
     * @throws \SmartyException
     */
    public function unregisterFilter(\Smarty\Internal\TemplateBase $obj, $type, $callback)
    {
        $smarty = $obj->_getSmartyObj();
        $this->_checkFilterType($type);
        if (isset($smarty->registered_filters[ $type ])) {
            $name = is_string($callback) ? $callback : $this->_getFilterName($callback);
            if (isset($smarty->registered_filters[ $type ][ $name ])) {
                unset($smarty->registered_filters[ $type ][ $name ]);
                if (empty($smarty->registered_filters[ $type ])) {
                    unset($smarty->registered_filters[ $type ]);
                }
            }
        }
        return $obj;
    }
}
