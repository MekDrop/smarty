<?php

namespace Smarty\Internal\Method;

use Smarty\Internal\Data;
use Smarty\Internal\Template;

/**
 * Smarty Method ClearAssign
 *
 * Smarty::clearAssign() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class ClearAssignMethod
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * clear the given assigned template variable(s).
     *
     * @param Data|Template|\Smarty $data
     * @param string|array                                            $tpl_var the template variable(s) to clear
     *
     * @return Data|Template|\Smarty
     *
     * @link https://www.smarty.net/docs/en/api.clear.assign.tpl
     * @api  Smarty::clearAssign()
     */
    public function clearAssign(Data $data, $tpl_var)
    {
        if (is_array($tpl_var)) {
            foreach ($tpl_var as $curr_var) {
                unset($data->tpl_vars[ $curr_var ]);
            }
        } else {
            unset($data->tpl_vars[ $tpl_var ]);
        }
        return $data;
    }
}
