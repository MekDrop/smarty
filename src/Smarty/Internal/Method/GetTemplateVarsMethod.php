<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method GetTemplateVars
 *
 * Smarty::getTemplateVars() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class GetTemplateVarsMethod
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * Returns a single or all template variables
     *
     * @api  Smarty::getTemplateVars()
     * @link https://www.smarty.net/docs/en/api.get.template.vars.tpl
     *
     * @param \Smarty\Internal\Data|\Smarty\Internal\Template|\Smarty $data
     * @param string                                                  $varName       variable name or null
     * @param \Smarty\Internal\Data|\Smarty\Internal\Template|\Smarty $_ptr          optional pointer to data object
     * @param bool                                                    $searchParents include parent templates?
     *
     * @return mixed variable value or or array of variables
     */
    public function getTemplateVars(
        \Smarty\Internal\Data $data,
        $varName = null,
        \Smarty\Internal\Data $_ptr = null,
        $searchParents = true
    ) {
        if (isset($varName)) {
            $_var = $this->_getVariable($data, $varName, $_ptr, $searchParents, false);
            if (is_object($_var)) {
                return $_var->value;
            } else {
                return null;
            }
        } else {
            $_result = array();
            if ($_ptr === null) {
                $_ptr = $data;
            }
            while ($_ptr !== null) {
                foreach ($_ptr->tpl_vars as $key => $var) {
                    if (!array_key_exists($key, $_result)) {
                        $_result[ $key ] = $var->value;
                    }
                }
                // not found, try at parent
                if ($searchParents && isset($_ptr->parent)) {
                    $_ptr = $_ptr->parent;
                } else {
                    $_ptr = null;
                }
            }
            if ($searchParents && isset(\Smarty::$global_tpl_vars)) {
                foreach (\Smarty::$global_tpl_vars as $key => $var) {
                    if (!array_key_exists($key, $_result)) {
                        $_result[ $key ] = $var->value;
                    }
                }
            }
            return $_result;
        }
    }

    /**
     * gets the object of a Smarty variable
     *
     * @param \Smarty\Internal\Data|\Smarty\Internal\Template|\Smarty $data
     * @param string                                                  $varName       the name of the Smarty variable
     * @param \Smarty\Internal\Data|\Smarty\Internal\Template|\Smarty $_ptr          optional pointer to data object
     * @param bool                                                    $searchParents search also in parent data
     * @param bool                                                    $errorEnable
     *
     * @return \Smarty\Variable
     */
    public function _getVariable(
        \Smarty\Internal\Data $data,
        $varName,
        \Smarty\Internal\Data $_ptr = null,
        $searchParents = true,
        $errorEnable = true
    ) {
        if ($_ptr === null) {
            $_ptr = $data;
        }
        while ($_ptr !== null) {
            if (isset($_ptr->tpl_vars[ $varName ])) {
                // found it, return it
                return $_ptr->tpl_vars[ $varName ];
            }
            // not found, try at parent
            if ($searchParents && isset($_ptr->parent)) {
                $_ptr = $_ptr->parent;
            } else {
                $_ptr = null;
            }
        }
        if (isset(\Smarty::$global_tpl_vars[ $varName ])) {
            // found it, return it
            return \Smarty::$global_tpl_vars[ $varName ];
        }
        if ($errorEnable && $data->_getSmartyObj()->error_unassigned) {
            // force a notice
            $x = $$varName;
        }
        return new \Smarty\Undefined\VariableUndefined;
    }
}
