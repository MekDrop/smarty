<?php
/**
 * This file is part of Smarty.
 *
 * (c) 2015 Uwe Tews
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Smarty\Internal\Compile\Block;

/**
 * Smarty Internal Plugin Compile Block Child Class
 *
 * @author Uwe Tews <uwe.tews@googlemail.com>
 */
class ChildBlock extends Smarty_Internal_Compile_Child
{
    /**
     * Tag name
     *
     * @var string
     */
    public $tag = 'block_child';
}
