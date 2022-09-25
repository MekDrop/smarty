<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Exception\SmartyException;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

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
     * @param TemplateBase|Template|Smarty $obj
     * @param string                                                          $type filter type
     * @param callback|string                                                 $callback
     *
     * @return Smarty|Template
     * @throws SmartyException
     *
     * @link https://www.smarty.net/docs/en/api.unregister.filter.tpl
     * @api  Smarty::unregisterFilter()
     */
    public function unregisterFilter(TemplateBase $obj, $type, $callback)
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
