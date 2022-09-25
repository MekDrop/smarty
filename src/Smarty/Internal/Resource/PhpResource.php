<?php

namespace Smarty\Internal\Resource;

use Smarty\Exception\SmartyException;
use Smarty\Internal\Template;
use Smarty\Template\CompiledTemplate;
use Smarty\Template\SourceTemplate;

/**
 * Smarty Internal Plugin Resource PHP
 * Implements the file system as resource for PHP templates
 *
 * @package    Smarty
 * @subpackage TemplateResources
 * @author     Uwe Tews
 * @author     Rodney Rehm
 */
class PhpResource extends FileResource
{
    /**
     * Flag that it's an uncompiled resource
     *
     * @var bool
     */
    public $uncompiled = true;

    /**
     * Resource does implement populateCompiledFilepath() method
     *
     * @var bool
     */
    public $hasCompiledHandler = true;

    /**
     * container for short_open_tag directive's value before executing PHP templates
     *
     * @var string
     */
    protected $short_open_tag;

    /**
     * Create a new PHP Resource
     */
    public function __construct()
    {
        $this->short_open_tag = function_exists('ini_get') ? ini_get('short_open_tag') : 1;
    }

    /**
     * Load template's source from file into current template object
     *
     * @param SourceTemplate $source source object
     *
     * @return string                 template source
     * @throws SmartyException        if source cannot be loaded
     */
    public function getContent(SourceTemplate $source)
    {
        if ($source->exists) {
            return '';
        }
        throw new SmartyException("Unable to read template {$source->type} '{$source->name}'");
    }

    /**
     * populate compiled object with compiled filepath
     *
     * @param CompiledTemplate $compiled  compiled object
     * @param Template $_template template object (is ignored)
     */
    public function populateCompiledFilepath(CompiledTemplate $compiled, Template $_template)
    {
        $compiled->filepath = $_template->source->filepath;
        $compiled->timestamp = $_template->source->timestamp;
        $compiled->exists = $_template->source->exists;
        $compiled->file_dependency[ $_template->source->uid ] =
            array(
                $compiled->filepath,
                $compiled->timestamp,
                $_template->source->type,
            );
    }

    /**
     * Render and output the template (without using the compiler)
     *
     * @param SourceTemplate   $source    source object
     * @param Template $_template template object
     *
     * @return void
     * @throws SmartyException          if template cannot be loaded or allow_php_templates is disabled
     */
    public function renderUncompiled(SourceTemplate $source, Template $_template)
    {
        if (!$source->smarty->allow_php_templates) {
            throw new SmartyException('PHP templates are disabled');
        }
        if (!$source->exists) {
            throw new SmartyException(
                "Unable to load template '{$source->type}:{$source->name}'" .
                ($_template->_isSubTpl() ? " in '{$_template->parent->template_resource}'" : '')
            );
        }
        // prepare variables
        extract($_template->getTemplateVars());
        // include PHP template with short open tags enabled
        if (function_exists('ini_set')) {
            ini_set('short_open_tag', '1');
        }
        /**
         *
         *
         * @var Template $_smarty_template
         * used in included file
         */
        $_smarty_template = $_template;
        include $source->filepath;
        if (function_exists('ini_set')) {
            ini_set('short_open_tag', $this->short_open_tag);
        }
    }
}
