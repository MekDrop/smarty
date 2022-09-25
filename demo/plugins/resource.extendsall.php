<?php

use Smarty\Exception\SmartyException;
use Smarty\Internal\Resource\ExtendsResource;
use Smarty\Internal\Template;
use Smarty\Resource;
use Smarty\Template\SourceTemplate;

/**
 * Extends All Resource
 * Resource Implementation modifying the extends-Resource to walk
 * through the template_dirs and inherit all templates of the same name
 *
 * @package Resource-examples
 * @author  Rodney Rehm
 */
class Smarty_Resource_Extendsall extends ExtendsResource
{
    /**
     * populate Source Object with meta data from Resource
     *
     * @param SourceTemplate $source    source object
     * @param Template|null  $_template template object
     *
     * @return void
     */
    public function populate(SourceTemplate $source, Template $_template = null)
    {
        $uid = '';
        $sources = array();
        $timestamp = 0;
        foreach ($source->smarty->getTemplateDir() as $key => $directory) {
            try {
                $s = Resource::source(null, $source->smarty, 'file:' . '[' . $key . ']' . $source->name);
                if (!$s->exists) {
                    continue;
                }
                $sources[ $s->uid ] = $s;
                $uid .= $s->filepath;
                $timestamp = $s->timestamp > $timestamp ? $s->timestamp : $timestamp;
            } catch (SmartyException $e) {
            }
        }
        if (!$sources) {
            $source->exists = false;
            return;
        }
        $sources = array_reverse($sources, true);
        reset($sources);
        $s = current($sources);
        $source->components = $sources;
        $source->filepath = $s->filepath;
        $source->uid = sha1($uid . $source->smarty->_joined_template_dir);
        $source->exists = true;
        $source->timestamp = $timestamp;
    }

    /**
     * Disable timestamp checks for extendsall resource.
     * The individual source components will be checked.
     *
     * @return bool false
     */
    public function checkTimestamps()
    {
        return false;
    }
}
