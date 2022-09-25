<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method CreateData
 *
 * Smarty::createData() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class CreateDataMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * creates a data object
     *
     * @api  Smarty::createData()
     * @link https://www.smarty.net/docs/en/api.create.data.tpl
     *
     * @param \Smarty\Internal\TemplateBase|\Smarty\Internal\Template|\Smarty      $obj
     * @param \Smarty\Internal\Template|\Smarty\Internal\Data|\Smarty\Data|\Smarty $parent next higher level of Smarty
     *                                                                                     variables
     * @param string                                                               $name   optional data block name
     *
     * @return \Smarty\Data data object
     */
    public function createData(\Smarty\Internal\TemplateBase $obj, \Smarty\Internal\Data $parent = null, $name = null)
    {
        /* @var \Smarty $smarty */
        $smarty = $obj->_getSmartyObj();
        $dataObj = new \Smarty\Data($parent, $smarty, $name);
        if ($smarty->debugging) {
            \Smarty\Internal\Debug::register_data($dataObj);
        }
        return $dataObj;
    }
}
