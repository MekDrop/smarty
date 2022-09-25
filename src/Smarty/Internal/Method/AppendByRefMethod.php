<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Internal\Data;
use Smarty\Internal\Template;
use Smarty\Variable;

/**
 * Smarty Method AppendByRef
 *
 * Smarty::appendByRef() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class AppendByRefMethod
{
    /**
     * appends values to template variables by reference
     *
     * @param Data|Template|Smarty $data
     * @param string                                                  $tpl_var the template variable name
     * @param mixed                                                   &$value  the referenced value to append
     * @param bool                                                    $merge   flag if array elements shall be merged
     *
     * @return Data|Template|Smarty
     * @link https://www.smarty.net/docs/en/api.append.by.ref.tpl
     *
     * @api  Smarty::appendByRef()
     */
    public static function appendByRef(Data $data, $tpl_var, &$value, $merge = false)
    {
        if ($tpl_var !== '' && isset($value)) {
            if (!isset($data->tpl_vars[ $tpl_var ])) {
                $data->tpl_vars[ $tpl_var ] = new Variable();
            }
            if (!is_array($data->tpl_vars[ $tpl_var ]->value)) {
                settype($data->tpl_vars[ $tpl_var ]->value, 'array');
            }
            if ($merge && is_array($value)) {
                foreach ($value as $_key => $_val) {
                    $data->tpl_vars[ $tpl_var ]->value[ $_key ] = &$value[ $_key ];
                }
            } else {
                $data->tpl_vars[ $tpl_var ]->value[] = &$value;
            }
            if ($data->_isTplObj() && $data->scope) {
                $data->ext->_updateScope->_updateScope($data, $tpl_var);
            }
        }
        return $data;
    }
}
