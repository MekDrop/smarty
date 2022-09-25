<?php
/**
 * Smarty Internal Plugin Compile Continue
 * Compiles the {continue} tag
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Uwe Tews
 */

namespace Smarty\Internal\Compile;

/**
 * Smarty Internal Plugin Compile Continue Class
 *
 * @package    Smarty
 * @subpackage Compiler
 */
class ContinueCompile extends Smarty_Internal_Compile_Break
{
    /**
     * Tag name
     *
     * @var string
     */
    public $tag = 'continue';
}
