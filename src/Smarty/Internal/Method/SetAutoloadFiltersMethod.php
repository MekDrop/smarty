<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method SetAutoloadFilters
 *
 * Smarty::setAutoloadFilters() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class SetAutoloadFiltersMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Valid filter types
     *
     * @var array
     */
    private $filterTypes = array('pre' => true, 'post' => true, 'output' => true, 'variable' => true);

    /**
     * Set autoload filters
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
     *@api Smarty::setAutoloadFilters()
     *
     */
    public function setAutoloadFilters(\Smarty\Internal\TemplateBase $obj, $filters, $type = null)
    {
        $smarty = $obj->_getSmartyObj();
        if ($type !== null) {
            $this->_checkFilterType($type);
            $smarty->autoload_filters[ $type ] = (array)$filters;
        } else {
            foreach ((array)$filters as $type => $value) {
                $this->_checkFilterType($type);
            }
            $smarty->autoload_filters = (array)$filters;
        }
        return $obj;
    }

    /**
     * Check if filter type is valid
     *
     * @param string $type
     *
     * @throws \Smarty\Exception\SmartyException
     */
    public function _checkFilterType($type)
    {
        if (!isset($this->filterTypes[ $type ])) {
            throw new \Smarty\Exception\SmartyException("Illegal filter type '{$type}'");
        }
    }
}
