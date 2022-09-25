<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method AddAutoloadFilters
 *
 * Smarty::addAutoloadFilters() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class AddAutoloadFiltersMethod extends \Smarty\Internal\Method\SetAutoloadFilters
{
    /**
     * Add autoload filters
     *
     * @api Smarty::setAutoloadFilters()
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param array                                                           $filters filters to load automatically
     * @param string                                                          $type    "pre", "output", … specify
     *                                                                                 the filter type to set.
     *                                                                                 Defaults to none treating
     *                                                                                 $filters' keys as the
     *                                                                                 appropriate types
     *
     * @return \Smarty|\Smarty\Internal\Template
     * @throws \Smarty\Exception\SmartyException
     */
    public function addAutoloadFilters(\Smarty\Internal\TemplateBase $obj, $filters, $type = null)
    {
        $smarty = $obj->_getSmartyObj();
        if ($type !== null) {
            $this->_checkFilterType($type);
            if (!empty($smarty->autoload_filters[ $type ])) {
                $smarty->autoload_filters[ $type ] = array_merge($smarty->autoload_filters[ $type ], (array)$filters);
            } else {
                $smarty->autoload_filters[ $type ] = (array)$filters;
            }
        } else {
            foreach ((array)$filters as $type => $value) {
                $this->_checkFilterType($type);
                if (!empty($smarty->autoload_filters[ $type ])) {
                    $smarty->autoload_filters[ $type ] =
                        array_merge($smarty->autoload_filters[ $type ], (array)$value);
                } else {
                    $smarty->autoload_filters[ $type ] = (array)$value;
                }
            }
        }
        return $obj;
    }
}
