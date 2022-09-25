<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method GetConfigVariable
 *
 * Smarty::getConfigVariable() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class GetConfigVariableMethod
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * gets  a config variable value
     *
     * @param \Smarty|\Smarty\Internal\Data|\Smarty\Internal\Template $data
     * @param string                                                  $varName the name of the config variable
     * @param bool                                                    $errorEnable
     *
     * @return null|string  the value of the config variable
     */
    public function getConfigVariable(\Smarty\Internal\Data $data, $varName = null, $errorEnable = true)
    {
        return $data->ext->configLoad->_getConfigVariable($data, $varName, $errorEnable);
    }
}
