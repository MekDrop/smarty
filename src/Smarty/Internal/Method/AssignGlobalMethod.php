<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Internal\Data;
use Smarty\Internal\Template;
use Smarty\Variable;

/**
 * Smarty Method AssignGlobal
 *
 * Smarty::assignGlobal() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class AssignGlobalMethod
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * assigns a global Smarty variable
     *
     * @param Data|Template|Smarty $data
     * @param string                                                  $varName the global variable name
     * @param mixed                                                   $value   the value to assign
     * @param boolean                                                 $nocache if true any output of this variable will
     *                                                                         be not cached
     *
     * @return Data|Template|Smarty
     */
    public function assignGlobal(Data $data, $varName, $value = null, $nocache = false)
    {
        if ($varName !== '') {
            Smarty::$global_tpl_vars[ $varName ] = new Variable($value, $nocache);
            $ptr = $data;
            while ($ptr->_isTplObj()) {
                $ptr->tpl_vars[ $varName ] = clone Smarty::$global_tpl_vars[ $varName ];
                $ptr = $ptr->parent;
            }
        }
        return $data;
    }
}
