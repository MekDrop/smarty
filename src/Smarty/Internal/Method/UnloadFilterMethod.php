<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method UnloadFilter
 *
 * Smarty::unloadFilter() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class UnloadFilterMethod extends LoadFilterMethod
{
    /**
     * load a filter of specified type and name
     *
     * @api  Smarty::unloadFilter()
     *
     * @link https://www.smarty.net/docs/en/api.unload.filter.tpl
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param string                                                          $type filter type
     * @param string                                                          $name filter name
     *
     * @return \Smarty\Internal\TemplateBase
     * @throws \Smarty\Exception\SmartyException
     */
    public function unloadFilter(\Smarty\Internal\TemplateBase $obj, $type, $name)
    {
        $smarty = $obj->_getSmartyObj();
        $this->_checkFilterType($type);
        if (isset($smarty->registered_filters[ $type ])) {
            $_filter_name = "smarty_{$type}filter_{$name}";
            if (isset($smarty->registered_filters[ $type ][ $_filter_name ])) {
                unset($smarty->registered_filters[ $type ][ $_filter_name ]);
                if (empty($smarty->registered_filters[ $type ])) {
                    unset($smarty->registered_filters[ $type ]);
                }
            }
        }
        return $obj;
    }
}
