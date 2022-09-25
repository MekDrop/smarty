<?php

namespace Smarty\Internal\Method;

use Smarty;
use Smarty\Exception\SmartyException;
use Smarty\Internal\Template;
use Smarty\Internal\TemplateBase;

/**
 * Smarty Method GetLiterals
 *
 * Smarty::getLiterals() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class LiteralsMethod
{
    /**
     * Valid for Smarty and template object
     *
     * @var int
     */
    public $objMap = 3;

    /**
     * Get literals
     *
     * @param TemplateBase|Template|Smarty $obj
     *
     * @return array list of literals
     *
     * @api Smarty::getLiterals()
     */
    public function getLiterals(TemplateBase $obj)
    {
        $smarty = $obj->_getSmartyObj();
        return (array)$smarty->literals;
    }

    /**
     * Add literals
     *
     * @param TemplateBase|Template|Smarty $obj
     * @param array|string                                                    $literals literal or list of literals
     *                                                                                  to addto add
     *
     * @return Smarty|Template
     * @throws SmartyException
     *
     * @api Smarty::addLiterals()
     */
    public function addLiterals(TemplateBase $obj, $literals = null)
    {
        if (isset($literals)) {
            $this->set($obj->_getSmartyObj(), (array)$literals);
        }
        return $obj;
    }

    /**
     * Set literals
     *
     * @param TemplateBase|Template|Smarty $obj
     * @param array|string                                                    $literals literal or list of literals
     *                                                                                  to setto set
     *
     * @return Smarty|Template
     * @throws SmartyException
     *@api Smarty::setLiterals()
     *
     */
    public function setLiterals(TemplateBase $obj, $literals = null)
    {
        $smarty = $obj->_getSmartyObj();
        $smarty->literals = array();
        if (!empty($literals)) {
            $this->set($smarty, (array)$literals);
        }
        return $obj;
    }

    /**
     * common setter for literals for easier handling of duplicates the
     * Smarty::$literals array gets filled with identical key values
     *
     * @param Smarty $smarty
     * @param array   $literals
     *
     * @throws SmartyException
     */
    private function set(Smarty $smarty, $literals)
    {
        $literals = array_combine($literals, $literals);
        $error = isset($literals[ $smarty->left_delimiter ]) ? array($smarty->left_delimiter) : array();
        $error = isset($literals[ $smarty->right_delimiter ]) ? $error[] = $smarty->right_delimiter : $error;
        if (!empty($error)) {
            throw new SmartyException(
                'User defined literal(s) "' . $error .
                '" may not be identical with left or right delimiter'
            );
        }
        $smarty->literals = array_merge((array)$smarty->literals, (array)$literals);
    }
}
