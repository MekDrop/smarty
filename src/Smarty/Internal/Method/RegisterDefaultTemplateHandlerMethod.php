<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method RegisterDefaultTemplateHandler
 *
 * Smarty::registerDefaultTemplateHandler() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class RegisterDefaultTemplateHandlerMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Register template default handler
     *
     * @api Smarty::registerDefaultTemplateHandler()
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param callable                                                        $callback class/method name
     *
     * @return \Smarty|\Smarty\Internal\Template
     * @throws \SmartyException              if $callback is not callable
     */
    public function registerDefaultTemplateHandler(\Smarty\Internal\TemplateBase $obj, $callback)
    {
        $smarty = $obj->_getSmartyObj();
        if (is_callable($callback)) {
            $smarty->default_template_handler_func = $callback;
        } else {
            throw new \SmartyException('Default template handler not callable');
        }
        return $obj;
    }

    /**
     * get default content from template or config resource handler
     *
     * @param \Smarty\Template\SourceTemplate $source
     *
     * @throws \SmartyException
     */
    public static function _getDefaultTemplate(\Smarty\Template\SourceTemplate $source)
    {
        if ($source->isConfig) {
            $default_handler = $source->smarty->default_config_handler_func;
        } else {
            $default_handler = $source->smarty->default_template_handler_func;
        }
        $_content = $_timestamp = null;
        $_return = call_user_func_array(
            $default_handler,
            array($source->type, $source->name, &$_content, &$_timestamp, $source->smarty)
        );
        if (is_string($_return)) {
            $source->exists = is_file($_return);
            if ($source->exists) {
                $source->timestamp = filemtime($_return);
            } else {
                throw new \SmartyException(
                    'Default handler: Unable to load ' .
                    ($source->isConfig ? 'config' : 'template') .
                    " default file '{$_return}' for '{$source->type}:{$source->name}'"
                );
            }
            $source->name = $source->filepath = $_return;
            $source->uid = sha1($source->filepath);
        } elseif ($_return === true) {
            $source->content = $_content;
            $source->exists = true;
            $source->uid = $source->name = sha1($_content);
            $source->handler = \Smarty\Resource::load($source->smarty, 'eval');
        } else {
            $source->exists = false;
            throw new \SmartyException(
                'Default handler: No ' . ($source->isConfig ? 'config' : 'template') .
                " default content for '{$source->type}:{$source->name}'"
            );
        }
    }
}
