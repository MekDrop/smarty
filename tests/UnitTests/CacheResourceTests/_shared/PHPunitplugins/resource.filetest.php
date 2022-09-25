<?php

class Smarty_Resource_Filetest extends \Smarty\Internal\Resource\FileResource
{
    /**
     * populate Source Object with meta data from Resource
     *
     * @param \Smarty\Template\SourceTemplate $source source object
     * @param \Smarty\Internal\Template|null $_template template object
     *
     * @throws \SmartyException
     */
    public function populate(\Smarty\Template\SourceTemplate $source, \Smarty\Internal\Template $_template = null)
    {
        parent::populate($source, $_template);
        if ($source->exists) {
            if (isset(CacheResourceTestCommon::$touchResource[$source->filepath])) {
                $source->timestamp = CacheResourceTestCommon::$touchResource[$source->filepath];
            }
        }
    }

}

