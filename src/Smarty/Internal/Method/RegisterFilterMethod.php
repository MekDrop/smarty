<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method RegisterFilter
 *
 * Smarty::registerFilter() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class RegisterFilterMethod
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
     * Registers a filter function
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param string                                                          $type filter type
     * @param callback                                                        $callback
     * @param string|null                                                     $name optional filter name
     *
     * @return \Smarty|\Smarty\Internal\Template
     * @throws \Smarty\Exception\SmartyException
     *@api  Smarty::registerFilter()
     *
     * @link https://www.smarty.net/docs/en/api.register.filter.tpl
     *
     */
    public function registerFilter(\Smarty\Internal\TemplateBase $obj, $type, $callback, $name = null)
    {
        $smarty = $obj->_getSmartyObj();
        $this->_checkFilterType($type);
        $name = isset($name) ? $name : $this->_getFilterName($callback);
        if (!is_callable($callback)) {
            throw new \Smarty\Exception\SmartyException("{$type}filter '{$name}' not callable");
        }
        $smarty->registered_filters[ $type ][ $name ] = $callback;
        return $obj;
    }

    /**
     * Return internal filter name
     *
     * @param callback $function_name
     *
     * @return string   internal filter name
     */
    public function _getFilterName($function_name)
    {
        if (is_array($function_name)) {
            $_class_name = (is_object($function_name[ 0 ]) ? get_class($function_name[ 0 ]) : $function_name[ 0 ]);
            return $_class_name . '_' . $function_name[ 1 ];
        } elseif (is_string($function_name)) {
            return $function_name;
        } else {
            return 'closure';
        }
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
