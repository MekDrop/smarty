<?php
/**
 * Smarty Internal Plugin Resource Extends
 *
 * @package    Smarty
 * @subpackage TemplateResources
 * @author     Uwe Tews
 * @author     Rodney Rehm
 */

namespace Smarty\Internal\Resource;

/**
 * Smarty Internal Plugin Resource Extends
 * Implements the file system as resource for Smarty which {extend}s a chain of template files templates
 *
 * @package    Smarty
 * @subpackage TemplateResources
 */
class ExtendsResource extends \Smarty\Resource
{
    /**
     * mbstring.overload flag
     *
     * @var int
     */
    public $mbstring_overload = 0;

    /**
     * populate Source Object with meta data from Resource
     *
     * @param \Smarty\Template\SourceTemplate   $source    source object
     * @param \Smarty\Internal\Template $_template template object
     *
     * @throws \SmartyException
     */
    public function populate(\Smarty\Template\SourceTemplate $source, \Smarty\Internal\Template $_template = null)
    {
        $uid = '';
        $sources = array();
        $components = explode('|', $source->name);
        $smarty = &$source->smarty;
        $exists = true;
        foreach ($components as $component) {
            /* @var \Smarty\Template\SourceTemplate $_s */
            $_s = \Smarty\Template\SourceTemplate::load(null, $smarty, $component);
            if ($_s->type === 'php') {
                throw new \SmartyException("Resource type {$_s->type} cannot be used with the extends resource type");
            }
            $sources[ $_s->uid ] = $_s;
            $uid .= $_s->filepath;
            if ($_template) {
                $exists = $exists && $_s->exists;
            }
        }
        $source->components = $sources;
        $source->filepath = $_s->filepath;
        $source->uid = sha1($uid . $source->smarty->_joined_template_dir);
        $source->exists = $exists;
        if ($_template) {
            $source->timestamp = $_s->timestamp;
        }
    }

    /**
     * populate Source Object with timestamp and exists from Resource
     *
     * @param \Smarty\Template\SourceTemplate $source source object
     */
    public function populateTimestamp(\Smarty\Template\SourceTemplate $source)
    {
        $source->exists = true;
        /* @var \Smarty\Template\SourceTemplate $_s */
        foreach ($source->components as $_s) {
            $source->exists = $source->exists && $_s->exists;
        }
        $source->timestamp = $source->exists ? $_s->getTimeStamp() : false;
    }

    /**
     * Load template's source from files into current template object
     *
     * @param \Smarty\Template\SourceTemplate $source source object
     *
     * @return string template source
     * @throws \SmartyException if source cannot be loaded
     */
    public function getContent(\Smarty\Template\SourceTemplate $source)
    {
        if (!$source->exists) {
            throw new \SmartyException("Unable to load template '{$source->type}:{$source->name}'");
        }
        $_components = array_reverse($source->components);
        $_content = '';
        /* @var \Smarty\Template\SourceTemplate $_s */
        foreach ($_components as $_s) {
            // read content
            $_content .= $_s->getContent();
        }
        return $_content;
    }

    /**
     * Determine basename for compiled filename
     *
     * @param \Smarty\Template\SourceTemplate $source source object
     *
     * @return string resource's basename
     */
    public function getBasename(\Smarty\Template\SourceTemplate $source)
    {
        return str_replace(':', '.', basename($source->filepath));
    }

    /*
      * Disable timestamp checks for extends resource.
      * The individual source components will be checked.
      *
      * @return bool
      */
    /**
     * @return bool
     */
    public function checkTimestamps()
    {
        return false;
    }
}
