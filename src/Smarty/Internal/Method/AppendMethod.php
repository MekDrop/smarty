<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Internal\Data;
use Smarty\Internal\Template;
use Smarty\Undefined\VariableUndefined;
use Smarty\Variable;

/**
 * Smarty Method Append
 *
 * Smarty::append() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class AppendMethod
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * appends values to template variables
     *
     * @param Data|Template|Smarty $data
     * @param array|string                                            $tpl_var the template variable name(s)
     * @param mixed                                                   $value   the value to append
     * @param bool                                                    $merge   flag if array elements shall be merged
     * @param bool                                                    $nocache if true any output of this variable will
     *                                                                         be not cached
     *
     * @return Data|Template|Smarty
     *
     * @api  Smarty::append()
     * @link https://www.smarty.net/docs/en/api.append.tpl
     *
     */
    public function append(Data $data, $tpl_var, $value = null, $merge = false, $nocache = false)
    {
        if (is_array($tpl_var)) {
            // $tpl_var is an array, ignore $value
            foreach ($tpl_var as $_key => $_val) {
                if ($_key !== '') {
                    $this->append($data, $_key, $_val, $merge, $nocache);
                }
            }
        } else {
            if ($tpl_var !== '' && isset($value)) {
                if (!isset($data->tpl_vars[ $tpl_var ])) {
                    $tpl_var_inst = $data->ext->getTemplateVars->_getVariable($data, $tpl_var, null, true, false);
                    if ($tpl_var_inst instanceof VariableUndefined) {
                        $data->tpl_vars[ $tpl_var ] = new Variable(null, $nocache);
                    } else {
                        $data->tpl_vars[ $tpl_var ] = clone $tpl_var_inst;
                    }
                }
                if (!(is_array($data->tpl_vars[ $tpl_var ]->value)
                      || $data->tpl_vars[ $tpl_var ]->value instanceof \ArrayAccess)
                ) {
                    settype($data->tpl_vars[ $tpl_var ]->value, 'array');
                }
                if ($merge && is_array($value)) {
                    foreach ($value as $_mkey => $_mval) {
                        $data->tpl_vars[ $tpl_var ]->value[ $_mkey ] = $_mval;
                    }
                } else {
                    $data->tpl_vars[ $tpl_var ]->value[] = $value;
                }
            }
            if ($data->_isTplObj() && $data->scope) {
                $data->ext->_updateScope->_updateScope($data, $tpl_var);
            }
        }
        return $data;
    }
}
