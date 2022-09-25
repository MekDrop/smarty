<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Exception\SmartyException;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

/**
 * Smarty Method AddAutoloadFilters
 *
 * Smarty::addAutoloadFilters() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class AddAutoloadFiltersMethod extends SetAutoloadFiltersMethod
{
    /**
     * Add autoload filters
     *
     * @param TemplateBase|Template|Smarty $obj
     * @param array $filters filters to load automatically
     * @param string                                                          $type    "pre", "output", … specify
     *                                                                                 the filter type to set.
     *                                                                                 Defaults to none treating
     *                                                                                 $filters' keys as the
     *                                                                                 appropriate types
     *
     * @return Smarty|Template
     * @throws SmartyException
     *@api Smarty::setAutoloadFilters()
     *
     */
    public function addAutoloadFilters(TemplateBase $obj, $filters, $type = null)
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
