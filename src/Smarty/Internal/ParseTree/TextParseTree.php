<?php

namespace Smarty\Internal\ParseTree;

use Smarty\Internal\ParseTree;
use Smarty\Internal\Templateparser;

/**
 * Smarty Internal Plugin Templateparser Parse Tree
 * These are classes to build parse tree in the template parser
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Thue Kristensen
 * @author     Uwe Tews
 *             *
 *             template text
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */
class TextParseTree extends ParseTree
{

    /**
     * Wether this section should be stripped on output to smarty php
     * @var bool
     */
    private $toBeStripped = false;

    /**
     * Create template text buffer
     *
     * @param string $data text
     * @param bool $toBeStripped wether this section should be stripped on output to smarty php
     */
    public function __construct($data, $toBeStripped = false)
    {
        $this->data = $data;
        $this->toBeStripped = $toBeStripped;
    }

    /**
     * Wether this section should be stripped on output to smarty php
     * @return bool
     */
    public function isToBeStripped() {
        return $this->toBeStripped;
    }

    /**
     * Return buffer content
     *
     * @param Templateparser $parser
     *
     * @return string text
     */
    public function to_smarty_php(Templateparser $parser)
    {
        return $this->data;
    }
}
