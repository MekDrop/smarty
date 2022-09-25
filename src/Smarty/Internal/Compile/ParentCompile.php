<?php
/**
 * This file is part of Smarty.
 *
 * (c) 2015 Uwe Tews
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Smarty\Internal\Compile;

/**
 * Smarty Internal Plugin Compile Parent Class
 *
 * @author Uwe Tews <uwe.tews@googlemail.com>
 */
class ParentCompile extends Smarty_Internal_Compile_Child
{
    /**
     * Tag name
     *
     * @var string
     */
    public $tag = 'parent';

    /**
     * Block type
     *
     * @var string
     */
    public $blockType = 'Parent';
}
