<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Data as SmartyData;
use Smarty\Internal\Data;
use Smarty\Internal\Debug;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

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
     * @param TemplateBase|Template|Smarty      $obj
     * @param Template|Data|SmartyData|Smarty $parent next higher level of Smarty
     *                                                                                     variables
     * @param string                                                               $name   optional data block name
     *
     * @return SmartyData data object
     *
     * @api  Smarty::createData()
     * @link https://www.smarty.net/docs/en/api.create.data.tpl
     *
     */
    public function createData(TemplateBase $obj, Data $parent = null, $name = null)
    {
        $smarty = $obj->_getSmartyObj();
        $dataObj = new SmartyData($parent, $smarty, $name);
        if ($smarty->debugging) {
            Debug::register_data($dataObj);
        }
        return $dataObj;
    }
}
