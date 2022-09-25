<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method RegisterDefaultConfigHandler
 *
 * Smarty::registerDefaultConfigHandler() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class RegisterDefaultConfigHandlerMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Register config default handler
     *
     * @api Smarty::registerDefaultConfigHandler()
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param callable                                                        $callback class/method name
     *
     * @return \Smarty|\Smarty\Internal\Template
     * @throws \SmartyException              if $callback is not callable
     */
    public function registerDefaultConfigHandler(\Smarty\Internal\TemplateBase $obj, $callback)
    {
        $smarty = $obj->_getSmartyObj();
        if (is_callable($callback)) {
            $smarty->default_config_handler_func = $callback;
        } else {
            throw new \SmartyException('Default config handler not callable');
        }
        return $obj;
    }
}
