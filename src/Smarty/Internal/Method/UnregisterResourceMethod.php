<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

/**
 * Smarty Method UnregisterResource
 *
 * Smarty::unregisterResource() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class UnregisterResourceMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Registers a resource to fetch a template
     *
     * @param TemplateBase|Template|Smarty $obj
     * @param string                                                          $type name of resource type
     *
     * @return Smarty|Template
     *
     * @link https://www.smarty.net/docs/en/api.unregister.resource.tpl
     * @api  Smarty::unregisterResource()
     */
    public function unregisterResource(TemplateBase $obj, $type)
    {
        $smarty = $obj->_getSmartyObj();
        if (isset($smarty->registered_resources[ $type ])) {
            unset($smarty->registered_resources[ $type ]);
        }
        return $obj;
    }
}
