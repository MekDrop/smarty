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

use Smarty\Internal\ParseTree;
use Smarty\Internal\Templateparser;

/**
 * Template element
 *
 * @package    Smarty
 * @subpackage Compiler
 * @ignore
 */
class TemplateParseTree extends ParseTree
{
    /**
     * Array of template elements
     *
     * @var array
     */
    public $subtrees = array();

    /**
     * Create root of parse tree for template elements
     */
    public function __construct()
    {
    }

    /**
     * Append buffer to subtree
     *
     * @param Templateparser $parser
     * @param ParseTree       $subtree
     */
    public function append_subtree(Templateparser $parser, ParseTree $subtree)
    {
        if (!empty($subtree->subtrees)) {
            $this->subtrees = array_merge($this->subtrees, $subtree->subtrees);
        } else {
            if ($subtree->data !== '') {
                $this->subtrees[] = $subtree;
            }
        }
    }

    /**
     * Append array to subtree
     *
     * @param Templateparser $parser
     * @param ParseTree[]    $array
     */
    public function append_array(Templateparser $parser, $array = array())
    {
        if (!empty($array)) {
            $this->subtrees = array_merge($this->subtrees, (array)$array);
        }
    }

    /**
     * Prepend array to subtree
     *
     * @param Templateparser $parser
     * @param ParseTree[]    $array
     */
    public function prepend_array(Templateparser $parser, $array = array())
    {
        if (!empty($array)) {
            $this->subtrees = array_merge((array)$array, $this->subtrees);
        }
    }

    /**
     * Sanitize and merge subtree buffers together
     *
     * @param Templateparser $parser
     *
     * @return string template code content
     */
    public function to_smarty_php(Templateparser $parser)
    {
        $code = '';

        foreach ($this->getChunkedSubtrees() as $chunk) {
            $text = '';
            switch ($chunk['mode']) {
                case 'textstripped':
                    foreach ($chunk['subtrees'] as $subtree) {
                        $text .= $subtree->to_smarty_php($parser);
                    }
                    $code .= preg_replace(
                        '/((<%)|(%>)|(<\?php)|(<\?)|(\?>)|(<\/?script))/',
                        "<?php echo '\$1'; ?>\n",
                        $parser->compiler->processText($text)
                    );
                    break;
                case 'text':
                    foreach ($chunk['subtrees'] as $subtree) {
                        $text .= $subtree->to_smarty_php($parser);
                    }
                    $code .= preg_replace(
                        '/((<%)|(%>)|(<\?php)|(<\?)|(\?>)|(<\/?script))/',
                        "<?php echo '\$1'; ?>\n",
                        $text
                    );
                    break;
                case 'tag':
                    foreach ($chunk['subtrees'] as $subtree) {
                        $text = $parser->compiler->appendCode($text, $subtree->to_smarty_php($parser));
                    }
                    $code .= $text;
                    break;
                default:
                    foreach ($chunk['subtrees'] as $subtree) {
                        $text = $subtree->to_smarty_php($parser);
                    }
                    $code .= $text;

            }
        }
        return $code;
    }

    private function getChunkedSubtrees() {
        $chunks = array();
        $currentMode = null;
        $currentChunk = array();
        for ($key = 0, $cnt = count($this->subtrees); $key < $cnt; $key++) {

            if ($this->subtrees[ $key ]->data === '' && in_array($currentMode, array('textstripped', 'text', 'tag'))) {
                continue;
            }

            if ($this->subtrees[ $key ] instanceof TextParseTree
                && $this->subtrees[ $key ]->isToBeStripped()) {
                $newMode = 'textstripped';
            } elseif ($this->subtrees[ $key ] instanceof TextParseTree) {
                $newMode = 'text';
            } elseif ($this->subtrees[ $key ] instanceof TagParseTree) {
                $newMode = 'tag';
            } else {
                $newMode = 'other';
            }

            if ($newMode == $currentMode) {
                $currentChunk[] = $this->subtrees[ $key ];
            } else {
                $chunks[] = array(
                    'mode' => $currentMode,
                    'subtrees' => $currentChunk
                );
                $currentMode = $newMode;
                $currentChunk = array($this->subtrees[ $key ]);
            }
        }
        if ($currentMode && $currentChunk) {
            $chunks[] = array(
                'mode' => $currentMode,
                'subtrees' => $currentChunk
            );
        }
        return $chunks;
    }
}
