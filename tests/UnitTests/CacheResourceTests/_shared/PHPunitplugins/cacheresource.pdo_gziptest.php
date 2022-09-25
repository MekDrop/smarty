<?php

use Smarty\Template\CachedTemplate;

require_once SMARTY_DIR . '../demo/plugins/cacheresource.pdo_gzip.php';

class Smarty_CacheResource_Pdo_Gziptest extends Smarty_CacheResource_Pdo_Gzip
{
    public $lockTime = 0;

    public function hasLock(Smarty $smarty, CachedTemplate $cached)
    {
        if ($this->lockTime) {
            $this->lockTime--;
            if (!$this->lockTime) {
                $this->releaseLock($smarty, $cached);
            }
        }
        return parent::hasLock($smarty, $cached);
    }
}
