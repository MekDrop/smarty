<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Internal\Data;
use Smarty\Internal\Template;

/**
 * Smarty Method ClearConfig
 *
 * Smarty::clearConfig() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class ClearConfigMethod
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * clear a single or all config variables
     *
     * @param Data|Template|Smarty $data
     * @param string|null                                             $name variable name or null
     *
     * @return Data|Template|Smarty
     *
     * @link https://www.smarty.net/docs/en/api.clear.config.tpl
     *
     * @api  Smarty::clearConfig()
     */
    public function clearConfig(Data $data, $name = null)
    {
        if (isset($name)) {
            unset($data->config_vars[ $name ]);
        } else {
            $data->config_vars = array();
        }
        return $data;
    }
}
