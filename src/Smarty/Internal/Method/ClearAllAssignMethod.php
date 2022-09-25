<?php

namespace Smarty\Internal\Method;

use Smarty\Internal\Data;
use Smarty\Internal\Template;

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
     * @param Data|Template|\Smarty $data
     *
     * @return Data|Template|\Smarty
     *
     * @api  Smarty::clearAllAssign()
     * @link https://www.smarty.net/docs/en/api.clear.all.assign.tpl
     */
    public function clearAllAssign(Data $data)
    {
        $data->tpl_vars = array();
        return $data;
    }
}
