<?php
/**
 * Smarty Internal Plugin Templateparser Parse Tree
 * These are classes to build parse tree in the template parser
 *
 * @package    Smarty
 * @subpackage Compiler
 * @author     Thue Kristensen
 * @author     Uwe Tews
 */

namespace Smarty\Internal\ParseTree;

/**
 * A complete smarty tag.
 *
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */
class TagParseTree extends \Smarty\Internal\ParseTree
{
    /**
     * Saved block nesting level
     *
     * @var int
     */
    public $saved_block_nesting;

    /**
     * Create parse tree buffer for Smarty tag
     *
     * @param \Smarty\Internal\Templateparser $parser parser object
     * @param string                          $data   content
     */
    public function __construct(\Smarty\Internal\Templateparser $parser, $data)
    {
        $this->data = $data;
        $this->saved_block_nesting = $parser->block_nesting_level;
    }

    /**
     * Return buffer content
     *
     * @param \Smarty\Internal\Templateparser $parser
     *
     * @return string content
     */
    public function to_smarty_php(\Smarty\Internal\Templateparser $parser)
    {
        return $this->data;
    }

    /**
     * Return complied code that loads the evaluated output of buffer content into a temporary variable
     *
     * @param \Smarty\Internal\Templateparser $parser
     *
     * @return string template code
     */
    public function assign_to_var(\Smarty\Internal\Templateparser $parser)
    {
        $var = $parser->compiler->getNewPrefixVariable();
        $tmp = $parser->compiler->appendCode('<?php ob_start();?>', $this->data);
        $tmp = $parser->compiler->appendCode($tmp, "<?php {$var}=ob_get_clean();?>");
        $parser->compiler->prefix_code[] = sprintf('%s', $tmp);
        return $var;
    }
}
