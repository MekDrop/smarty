<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Exception\SmartyException;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

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
     * @param TemplateBase|Template|Smarty $obj
     * @param callable                                                        $callback class/method name
     *
     * @return Smarty|Template
     * @throws SmartyException              if $callback is not callable
     *
     * @api  Smarty::registerDefaultPluginHandler()
     * @link https://www.smarty.net/docs/en/api.register.default.plugin.handler.tpl
     */
    public function registerDefaultPluginHandler(TemplateBase $obj, $callback)
    {
        $smarty = $obj->_getSmartyObj();
        if (is_callable($callback)) {
            $smarty->default_plugin_handler_func = $callback;
        } else {
            throw new SmartyException("Default plugin handler '$callback' not callable");
        }
        return $obj;
    }
}
