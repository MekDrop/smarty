<?php

// compiler.testclose.php
use Smarty\Internal\CompileBase;

class smarty_compiler_testclose extends CompileBase
{
    public function execute($args, $compiler)
    {

        $this->closeTag($compiler, 'test');

        return '';
    }
}
