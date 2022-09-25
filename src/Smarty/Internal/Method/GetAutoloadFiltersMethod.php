<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method GetAutoloadFilters
 *
 * Smarty::getAutoloadFilters() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class GetAutoloadFiltersMethod extends \Smarty\Internal\Method\SetAutoloadFilters
{
    /**
     * Get autoload filters
     *
     * @api Smarty::getAutoloadFilters()
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param string                                                          $type type of filter to get auto loads
     *                                                                              for. Defaults to all autoload
     *                                                                              filters
     *
     * @return array array( 'type1' => array( 'filter1', 'filter2', … ) ) or array( 'filter1', 'filter2', …) if $type
     *                was specified
     * @throws \Smarty\Exception\SmartyException
     */
    public function getAutoloadFilters(\Smarty\Internal\TemplateBase $obj, $type = null)
    {
        $smarty = $obj->_getSmartyObj();
        if ($type !== null) {
            $this->_checkFilterType($type);
            return isset($smarty->autoload_filters[ $type ]) ? $smarty->autoload_filters[ $type ] : array();
        }
        return $smarty->autoload_filters;
    }
}
