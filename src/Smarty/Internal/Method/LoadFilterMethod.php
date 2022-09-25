<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method LoadFilter
 *
 * Smarty::loadFilter() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class LoadFilterMethod
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
     * load a filter of specified type and name
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param string                                                          $type filter type
     * @param string                                                          $name filter name
     *
     * @return bool
     * @throws \Smarty\Exception\SmartyException if filter could not be loaded
     *@link https://www.smarty.net/docs/en/api.load.filter.tpl
     *
     * @api  Smarty::loadFilter()
     *
     */
    public function loadFilter(\Smarty\Internal\TemplateBase $obj, $type, $name)
    {
        $smarty = $obj->_getSmartyObj();
        $this->_checkFilterType($type);
        $_plugin = "smarty_{$type}filter_{$name}";
        $_filter_name = $_plugin;
        if (is_callable($_plugin)) {
            $smarty->registered_filters[ $type ][ $_filter_name ] = $_plugin;
            return true;
        }
        if ($smarty->loadPlugin($_plugin)) {
            if (class_exists($_plugin, false)) {
                $_plugin = array($_plugin, 'execute');
            }
            if (is_callable($_plugin)) {
                $smarty->registered_filters[ $type ][ $_filter_name ] = $_plugin;
                return true;
            }
        }
        throw new \Smarty\Exception\SmartyException("{$type}filter '{$name}' not found or callable");
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
