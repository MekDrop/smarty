<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method RegisterDefaultPluginHandler
 *
 * Smarty::registerDefaultPluginHandler() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class RegisterDefaultPluginHandlerMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Registers a default plugin handler
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param callable                                                        $callback class/method name
     *
     * @return \Smarty|\Smarty\Internal\Template
     * @throws \Smarty\Exception\SmartyException              if $callback is not callable
     *@api  Smarty::registerDefaultPluginHandler()
     * @link https://www.smarty.net/docs/en/api.register.default.plugin.handler.tpl
     *
     */
    public function registerDefaultPluginHandler(\Smarty\Internal\TemplateBase $obj, $callback)
    {
        $smarty = $obj->_getSmartyObj();
        if (is_callable($callback)) {
            $smarty->default_plugin_handler_func = $callback;
        } else {
            throw new \Smarty\Exception\SmartyException("Default plugin handler '$callback' not callable");
        }
        return $obj;
    }
}
