<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Exception\SmartyException;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

/**
 * Smarty Method GetAutoloadFilters
 *
 * Smarty::getAutoloadFilters() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class GetAutoloadFiltersMethod extends SetAutoloadFiltersMethod
{
    /**
     * Get autoload filters
     *
     * @param TemplateBase|Template|Smarty $obj
     * @param string $type type of filter to get auto loads
     *                                                                              for. Defaults to all autoload
     *                                                                              filters
     *
     * @return array array( 'type1' => array( 'filter1', 'filter2', … ) ) or array( 'filter1', 'filter2', …) if $type
     *                was specified
     * @throws SmartyException
     *
     * @api Smarty::getAutoloadFilters()
     */
    public function getAutoloadFilters(TemplateBase $obj, $type = null)
    {
        $smarty = $obj->_getSmartyObj();
        if ($type !== null) {
            $this->_checkFilterType($type);
            return isset($smarty->autoload_filters[ $type ]) ? $smarty->autoload_filters[ $type ] : array();
        }
        return $smarty->autoload_filters;
    }
}
