<?php

namespace Smarty\Internal\Method;

use Smarty\Internal\Data;
use Smarty\Internal\Template;
use Smarty\Variable;

/**
 * Smarty Method AssignByRef
 *
 * Smarty::assignByRef() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class AssignByRefMethod
{
    /**
     * assigns values to template variables by reference
     *
     * @param Data|Template|\Smarty $data
     * @param string                                                  $tpl_var the template variable name
     * @param                                                         $value
     * @param boolean                                                 $nocache if true any output of this variable will
     *                                                                         be not cached
     *
     * @return Data|Template|\Smarty
     */
    public function assignByRef(Data $data, $tpl_var, &$value, $nocache)
    {
        if ($tpl_var !== '') {
            $data->tpl_vars[ $tpl_var ] = new Variable(null, $nocache);
            $data->tpl_vars[ $tpl_var ]->value = &$value;
            if ($data->_isTplObj() && $data->scope) {
                $data->ext->_updateScope->_updateScope($data, $tpl_var);
            }
        }
        return $data;
    }
}
