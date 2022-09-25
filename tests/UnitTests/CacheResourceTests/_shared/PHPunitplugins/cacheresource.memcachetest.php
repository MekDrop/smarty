<?php

require_once SMARTY_DIR . '../demo/plugins/cacheresource.memcache.php';

class Smarty_CacheResource_Memcachetest extends Smarty_CacheResource_Memcache
{
    public $lockTime = 0;

    public function hasLock(Smarty $smarty, \Smarty\Template\CachedTemplate $cached)
    {
        if ($this->lockTime) {
            $this->lockTime--;
            if (!$this->lockTime) {
                $this->releaseLock($smarty, $cached);
            }
        }
        return parent::hasLock($smarty, $cached);
    }

    public function get(\Smarty\Internal\Template $_template)
    {
        $this->contents = array();
        $this->timestamps = array();
        $t = $this->getContent($_template);

        return $t ? $t : null;
    }

    public function __sleep()
    {
        return array();
    }

    public function __wakeup()
    {
        $this->__construct();
    }
}
