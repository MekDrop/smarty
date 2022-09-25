<?php

// compiler.testclose.php
class smarty_compiler_testclose extends \Smarty\Internal\CompileBase
{
    public function execute($args, $compiler)
    {

        $this->closeTag($compiler, 'test');

        return '';
    }
}
