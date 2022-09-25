<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Internal\Data;
use Smarty\Internal\Template;

/**
 * Smarty Method GetConfigVars
 *
 * Smarty::getConfigVars() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class GetConfigVarsMethod
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * Returns a single or all config variables
     *
     * @param Data|Template|Smarty $data
     * @param string                                                  $varname        variable name or null
     * @param bool                                                    $search_parents include parent templates?
     *
     * @return mixed variable value or or array of variables
     *
     * @api  Smarty::getConfigVars()
     * @link https://www.smarty.net/docs/en/api.get.config.vars.tpl
     */
    public function getConfigVars(Data $data, $varname = null, $search_parents = true)
    {
        $_ptr = $data;
        $var_array = array();
        while ($_ptr !== null) {
            if (isset($varname)) {
                if (isset($_ptr->config_vars[ $varname ])) {
                    return $_ptr->config_vars[ $varname ];
                }
            } else {
                $var_array = array_merge($_ptr->config_vars, $var_array);
            }
            // not found, try at parent
            if ($search_parents) {
                $_ptr = $_ptr->parent;
            } else {
                $_ptr = null;
            }
        }
        if (isset($varname)) {
            return '';
        } else {
            return $var_array;
        }
    }
}
