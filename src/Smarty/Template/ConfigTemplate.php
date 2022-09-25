<?php
/**
 * Smarty Config Source Plugin
 *
 * @package    Smarty
 * @subpackage TemplateResources
 * @author     Uwe Tews
 */

namespace Smarty\Template;

/**
 * Smarty Config Resource Data Object
 * Meta Data Container for Template Files
 *
 * @package    Smarty
 * @subpackage TemplateResources
 * @author     Uwe Tews
 */
class ConfigTemplate extends \Smarty\Template\SourceTemplate
{
    /**
     * array of section names, single section or null
     *
     * @var null|string|array
     */
    public $config_sections = null;

    /**
     * scope into which the config variables shall be loaded
     *
     * @var int
     */
    public $scope = 0;

    /**
     * Flag that source is a config file
     *
     * @var bool
     */
    public $isConfig = true;

    /**
     * Name of the Class to compile this resource's contents with
     *
     * @var string
     */
    public $compiler_class = '\Smarty\Internal\Config\File\CompilerFile';

    /**
     * Name of the Class to tokenize this resource's contents with
     *
     * @var string
     */
    public $template_lexer_class = '\Smarty\Internal\Configfilelexer';

    /**
     * Name of the Class to parse this resource's contents with
     *
     * @var string
     */
    public $template_parser_class = '\Smarty\Internal\Configfileparser';

    /**
     * initialize Source Object for given resource
     * Either [$_template] or [$smarty, $template_resource] must be specified
     *
     * @param \Smarty\Internal\Template $_template         template object
     * @param \Smarty                   $smarty            smarty object
     * @param string                   $template_resource resource identifier
     *
     * @return \Smarty\Template\ConfigTemplate Source Object
     * @throws \Smarty\Exception\SmartyException
     */
    public static function load(
        \Smarty\Internal\Template $_template = null,
        Smarty $smarty = null,
        $template_resource = null
    ) {
        static $_incompatible_resources = array('extends' => true, 'php' => true);
        if ($_template) {
            $smarty = $_template->smarty;
            $template_resource = $_template->template_resource;
        }
        if (empty($template_resource)) {
            throw new \Smarty\Exception\SmartyException('Source: Missing  name');
        }
        // parse resource_name, load resource handler
        list($name, $type) = \Smarty\Resource::parseResourceName($template_resource, $smarty->default_config_type);
        // make sure configs are not loaded via anything smarty can't handle
        if (isset($_incompatible_resources[ $type ])) {
            throw new \Smarty\Exception\SmartyException("Unable to use resource '{$type}' for config");
        }
        $source = new \Smarty\Template\ConfigTemplate($smarty, $template_resource, $type, $name);
        $source->handler->populate($source, $_template);
        if (!$source->exists && isset($smarty->default_config_handler_func)) {
            \Smarty\Internal\Method\RegisterDefaultTemplateHandlerMethod::_getDefaultTemplate($source);
            $source->handler->populate($source, $_template);
        }
        return $source;
    }
}
