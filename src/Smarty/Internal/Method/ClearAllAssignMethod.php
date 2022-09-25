<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method ClearAllAssign
 *
 * Smarty::clearAllAssign() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class ClearAllAssignMethod
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * clear all the assigned template variables.
     *
     * @api  Smarty::clearAllAssign()
     * @link https://www.smarty.net/docs/en/api.clear.all.assign.tpl
     *
     * @param \Smarty\Internal\Data|\Smarty\Internal\Template|\Smarty $data
     *
     * @return \Smarty\Internal\Data|\Smarty\Internal\Template|\Smarty
     */
    public function clearAllAssign(\Smarty\Internal\Data $data)
    {
        $data->tpl_vars = array();
        return $data;
    }
}
