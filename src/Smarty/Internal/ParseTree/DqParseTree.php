<?php
/**
 * Double quoted string inside a tag.
 *
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */

namespace Smarty\Internal\ParseTree;

/**
 * Double quoted string inside a tag.
 *
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */
class DqParseTree extends \Smarty\Internal\ParseTree
{
    /**
     * Create parse tree buffer for double quoted string subtrees
     *
     * @param object                    $parser  parser object
     * @param \Smarty\Internal\ParseTree $subtree parse tree buffer
     */
    public function __construct($parser, \Smarty\Internal\ParseTree $subtree)
    {
        $this->subtrees[] = $subtree;
        if ($subtree instanceof \Smarty\Internal\ParseTree\TagParseTree) {
            $parser->block_nesting_level = count($parser->compiler->_tag_stack);
        }
    }

    /**
     * Append buffer to subtree
     *
     * @param \Smarty\Internal\Templateparser $parser
     * @param \Smarty\Internal\ParseTree       $subtree parse tree buffer
     */
    public function append_subtree(\Smarty\Internal\Templateparser $parser, \Smarty\Internal\ParseTree $subtree)
    {
        $last_subtree = count($this->subtrees) - 1;
        if ($last_subtree >= 0 && $this->subtrees[ $last_subtree ] instanceof \Smarty\Internal\ParseTree\TagParseTree
            && $this->subtrees[ $last_subtree ]->saved_block_nesting < $parser->block_nesting_level
        ) {
            if ($subtree instanceof \Smarty\Internal\ParseTree\CodeParseTree) {
                $this->subtrees[ $last_subtree ]->data =
                    $parser->compiler->appendCode(
                        $this->subtrees[ $last_subtree ]->data,
                        '<?php echo ' . $subtree->data . ';?>'
                    );
            } elseif ($subtree instanceof DqContentParseTree) {
                $this->subtrees[ $last_subtree ]->data =
                    $parser->compiler->appendCode(
                        $this->subtrees[ $last_subtree ]->data,
                        '<?php echo "' . $subtree->data . '";?>'
                    );
            } else {
                $this->subtrees[ $last_subtree ]->data =
                    $parser->compiler->appendCode($this->subtrees[ $last_subtree ]->data, $subtree->data);
            }
        } else {
            $this->subtrees[] = $subtree;
        }
        if ($subtree instanceof \Smarty\Internal\ParseTree\TagParseTree) {
            $parser->block_nesting_level = count($parser->compiler->_tag_stack);
        }
    }

    /**
     * Merge subtree buffer content together
     *
     * @param \Smarty\Internal\Templateparser $parser
     *
     * @return string compiled template code
     */
    public function to_smarty_php(\Smarty\Internal\Templateparser $parser)
    {
        $code = '';
        foreach ($this->subtrees as $subtree) {
            if ($code !== '') {
                $code .= '.';
            }
            if ($subtree instanceof \Smarty\Internal\ParseTree\TagParseTree) {
                $more_php = $subtree->assign_to_var($parser);
            } else {
                $more_php = $subtree->to_smarty_php($parser);
            }
            $code .= $more_php;
            if (!$subtree instanceof DqContentParseTree) {
                $parser->compiler->has_variable_string = true;
            }
        }
        return $code;
    }
}
