<?php
/**
 * Double quoted string inside a tag.
 *
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */

namespace Smarty\Internal\ParseTree;

use Smarty\Internal\ParseTree;
use Smarty\Internal\Templateparser;

/**
 * Double quoted string inside a tag.
 *
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */
class DqParseTree extends ParseTree
{
    /**
     * Create parse tree buffer for double quoted string subtrees
     *
     * @param object                    $parser  parser object
     * @param ParseTree $subtree parse tree buffer
     */
    public function __construct($parser, ParseTree $subtree)
    {
        $this->subtrees[] = $subtree;
        if ($subtree instanceof TagParseTree) {
            $parser->block_nesting_level = count($parser->compiler->_tag_stack);
        }
    }

    /**
     * Append buffer to subtree
     *
     * @param Templateparser $parser
     * @param ParseTree       $subtree parse tree buffer
     */
    public function append_subtree(Templateparser $parser, ParseTree $subtree)
    {
        $last_subtree = count($this->subtrees) - 1;
        if ($last_subtree >= 0 && $this->subtrees[ $last_subtree ] instanceof TagParseTree
            && $this->subtrees[ $last_subtree ]->saved_block_nesting < $parser->block_nesting_level
        ) {
            if ($subtree instanceof CodeParseTree) {
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
        if ($subtree instanceof TagParseTree) {
            $parser->block_nesting_level = count($parser->compiler->_tag_stack);
        }
    }

    /**
     * Merge subtree buffer content together
     *
     * @param Templateparser $parser
     *
     * @return string compiled template code
     */
    public function to_smarty_php(Templateparser $parser)
    {
        $code = '';
        foreach ($this->subtrees as $subtree) {
            if ($code !== '') {
                $code .= '.';
            }
            if ($subtree instanceof TagParseTree) {
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
