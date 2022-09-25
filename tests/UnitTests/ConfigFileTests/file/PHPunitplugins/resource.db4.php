<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     resource.db3.php
 * Type:     resource
 * Name:     db
 * Purpose:  Fetches templates from a database
 * -------------------------------------------------------------
 */

use Smarty\Internal\Template;
use Smarty\Resource;
use Smarty\Template\SourceTemplate;

class Smarty_Resource_Db4 extends Resource
{
    public function populate(SourceTemplate $source, Template $_template = null)
    {
        $source->filepath = 'db4:';
        $source->uid = sha1($source->resource);
        $source->timestamp = 0;
        $source->exists = true;
    }

    public function getContent(SourceTemplate $source)
    {
        return "foo = 'bar'\n";
    }
}
