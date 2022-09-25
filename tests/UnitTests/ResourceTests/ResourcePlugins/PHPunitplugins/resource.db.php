<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     resource.db.php
 * Type:     resource
 * Name:     db
 * Purpose:  Fetches templates from a database
 * -------------------------------------------------------------
 */

use Smarty\Internal\Template;
use Smarty\Resource\RecompiledResource;
use Smarty\Template\SourceTemplate;

class Smarty_Resource_Db extends RecompiledResource {

    public function populate(SourceTemplate $source, Template $_template = null) {
        $source->filepath = 'db:';
        $source->uid = sha1($source->resource);
        $source->timestamp = 1000000000;
        $source->exists = true;
    }

    public function getContent(SourceTemplate $source) {
        return '{$x="hello world"}{$x}';
    }
}
