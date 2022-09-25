<?php

namespace Smarty\Internal\Method;

use Exception;
use Smarty;
use Smarty\Exception\SmartyException;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

/**
 * Smarty Method GetTags
 *
 * Smarty::getTags() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class GetTagsMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Return array of tag/attributes of all tags used by an template
     *
     * @param TemplateBase|Template|Smarty $obj
     * @param null|string|Template                            $template
     *
     * @return array of tag/attributes
     * @throws Exception
     * @throws SmartyException
     *
     * @link https://www.smarty.net/docs/en/api.get.tags.tpl
     * @api  Smarty::getTags()
     */
    public function getTags(TemplateBase $obj, $template = null)
    {
        /* @var Smarty $smarty */
        $smarty = $obj->_getSmartyObj();
        if ($obj->_isTplObj() && !isset($template)) {
            $tpl = clone $obj;
        } elseif (isset($template) && $template->_isTplObj()) {
            $tpl = clone $template;
        } elseif (isset($template) && is_string($template)) {
            /* @var Template $tpl */
            $tpl = new $smarty->template_class($template, $smarty);
            // checks if template exists
            if (!$tpl->source->exists) {
                throw new SmartyException("Unable to load template {$tpl->source->type} '{$tpl->source->name}'");
            }
        }
        if (isset($tpl)) {
            $tpl->smarty = clone $tpl->smarty;
            $tpl->smarty->_cache[ 'get_used_tags' ] = true;
            $tpl->_cache[ 'used_tags' ] = array();
            $tpl->smarty->merge_compiled_includes = false;
            $tpl->smarty->disableSecurity();
            $tpl->caching = Smarty::CACHING_OFF;
            $tpl->loadCompiler();
            $tpl->compiler->compileTemplate($tpl);
            return $tpl->_cache[ 'used_tags' ];
        }
        throw new SmartyException('Missing template specification');
    }
}
