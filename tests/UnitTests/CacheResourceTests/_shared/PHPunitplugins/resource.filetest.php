<?php

use Smarty\Exception\SmartyException;
use Smarty\Internal\Resource\FileResource;
use Smarty\Internal\Template;
use Smarty\Template\SourceTemplate;

class Smarty_Resource_Filetest extends FileResource
{
    /**
     * populate Source Object with meta data from Resource
     *
     * @param SourceTemplate $source source object
     * @param Template|null $_template template object
     *
     * @throws SmartyException
     */
    public function populate(SourceTemplate $source, Template $_template = null)
    {
        parent::populate($source, $_template);
        if ($source->exists) {
            if (isset(CacheResourceTestCommon::$touchResource[$source->filepath])) {
                $source->timestamp = CacheResourceTestCommon::$touchResource[$source->filepath];
            }
        }
    }

}

