<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method RegisterPlugin
 *
 * Smarty::registerPlugin() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class RegisterPluginMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Registers plugin to be used in templates
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param string                                                          $type       plugin type
     * @param string                                                          $name       name of template tag
     * @param callback                                                        $callback   PHP callback to register
     * @param bool                                                            $cacheable  if true (default) this
     *                                                                                    function is cache able
     * @param mixed                                                           $cache_attr caching attributes if any
     *
     * @return \Smarty|\Smarty\Internal\Template
     * @throws \Smarty\Exception\SmartyException              when the plugin tag is invalid
     *@api  Smarty::registerPlugin()
     * @link https://www.smarty.net/docs/en/api.register.plugin.tpl
     *
     */
    public function registerPlugin(
        \Smarty\Internal\TemplateBase $obj,
        $type,
        $name,
        $callback,
        $cacheable = true,
        $cache_attr = null
    ) {
        $smarty = $obj->_getSmartyObj();
        if (isset($smarty->registered_plugins[ $type ][ $name ])) {
            throw new \Smarty\Exception\SmartyException("Plugin tag '{$name}' already registered");
        } elseif (!is_callable($callback)) {
            throw new \Smarty\Exception\SmartyException("Plugin '{$name}' not callable");
        } elseif ($cacheable && $cache_attr) {
            throw new \Smarty\Exception\SmartyException("Cannot set caching attributes for plugin '{$name}' when it is cacheable.");
        } else {
            $smarty->registered_plugins[ $type ][ $name ] = array($callback, (bool)$cacheable, (array)$cache_attr);
        }
        return $obj;
    }
}
