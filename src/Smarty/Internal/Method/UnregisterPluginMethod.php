<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method UnregisterPlugin
 *
 * Smarty::unregisterPlugin() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class UnregisterPluginMethod
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
     * @api  Smarty::unregisterPlugin()
     * @link https://www.smarty.net/docs/en/api.unregister.plugin.tpl
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty $obj
     * @param string                                                          $type plugin type
     * @param string                                                          $name name of template tag
     *
     * @return \Smarty|\Smarty\Internal\Template
     */
    public function unregisterPlugin(\Smarty\Internal\TemplateBase $obj, $type, $name)
    {
        $smarty = $obj->_getSmartyObj();
        if (isset($smarty->registered_plugins[ $type ][ $name ])) {
            unset($smarty->registered_plugins[ $type ][ $name ]);
        }
        return $obj;
    }
}
