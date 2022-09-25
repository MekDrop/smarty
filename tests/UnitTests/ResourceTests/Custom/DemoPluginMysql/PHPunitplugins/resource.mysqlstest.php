<?php
require_once SMARTY_DIR . '../demo/plugins/resource.mysqls.php';

class Smarty_Resource_Mysqlstest extends Smarty_Resource_Mysqls
{
    public function __construct()
    {
        try {
            $this->db = PHPUnit_Smarty::$pdo;
        }
        catch
            (PDOException $e) {
                throw new \Smarty\Exception\SmartyException('Mysql Resource failed: ' . $e->getMessage());
            }
        $this->fetch = $this->db->prepare('SELECT modified, source FROM templates WHERE name = :name');
    }
}

