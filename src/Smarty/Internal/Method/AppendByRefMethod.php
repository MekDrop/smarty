<?php

namespace Smarty\Internal\Method;

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
     * @api  Smarty::appendByRef()
     * @link https://www.smarty.net/docs/en/api.append.by.ref.tpl
     *
     * @param \Smarty\Internal\Data|\Smarty\Internal\Template|\Smarty $data
     * @param string                                                  $tpl_var the template variable name
     * @param mixed                                                   &$value  the referenced value to append
     * @param bool                                                    $merge   flag if array elements shall be merged
     *
     * @return \Smarty\Internal\Data|\Smarty\Internal\Template|\Smarty
     */
    public static function appendByRef(\Smarty\Internal\Data $data, $tpl_var, &$value, $merge = false)
    {
        if ($tpl_var !== '' && isset($value)) {
            if (!isset($data->tpl_vars[ $tpl_var ])) {
                $data->tpl_vars[ $tpl_var ] = new \Smarty\Variable();
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
