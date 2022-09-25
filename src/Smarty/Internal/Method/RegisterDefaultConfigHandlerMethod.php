<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Exception\SmartyException;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

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
     * @param TemplateBase|Template|Smarty $obj
     * @param callable                                                        $callback class/method name
     *
     * @return Smarty|Template
     * @throws SmartyException              if $callback is not callable
     *
     * @api Smarty::registerDefaultConfigHandler()
     */
    public function registerDefaultConfigHandler(TemplateBase $obj, $callback)
    {
        $smarty = $obj->_getSmartyObj();
        if (is_callable($callback)) {
            $smarty->default_config_handler_func = $callback;
        } else {
            throw new SmartyException('Default config handler not callable');
        }
        return $obj;
    }
}
