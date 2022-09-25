<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method MustCompile
 *
 * \Smarty\Internal\Template::mustCompile() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class MustCompileMethod
{
    /**
     * Valid for template object
     *
     * @var int
     */
    public $objMap = 2;

    /**
     * Returns if the current template must be compiled by the Smarty compiler
     * It does compare the timestamps of template source and the compiled templates and checks the force compile
     * configuration
     *
     * @param \Smarty\Internal\Template $_template
     *
     * @return bool
     * @throws \SmartyException
     */
    public function mustCompile(\Smarty\Internal\Template $_template)
    {
        if (!$_template->source->exists) {
            if ($_template->_isSubTpl()) {
                $parent_resource = " in '{$_template->parent->template_resource}'";
            } else {
                $parent_resource = '';
            }
            throw new \SmartyException("Unable to load template {$_template->source->type} '{$_template->source->name}'{$parent_resource}");
        }
        if ($_template->mustCompile === null) {
            $_template->mustCompile = (!$_template->source->handler->uncompiled &&
                                       ($_template->smarty->force_compile || $_template->source->handler->recompiled ||
                                        !$_template->compiled->exists || ($_template->compile_check &&
                                                                          $_template->compiled->getTimeStamp() <
                                                                          $_template->source->getTimeStamp())));
        }
        return $_template->mustCompile;
    }
}
