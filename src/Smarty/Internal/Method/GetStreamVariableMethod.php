<?php

namespace Smarty\Internal\Method;

/**
 * Smarty Method GetStreamVariable
 *
 * Smarty::getStreamVariable() method
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 */
class GetStreamVariableMethod
{
    /**
     * Valid for all objects
     *
     * @var int
     */
    public $objMap = 7;

    /**
     * gets  a stream variable
     *
     * @param \Smarty\Internal\Data|\Smarty\Internal\Template|\Smarty $data
     * @param string                                                  $variable the stream of the variable
     *
     * @return mixed
     * @throws \Smarty\Exception\SmartyException
     *@api Smarty::getStreamVariable()
     *
     */
    public function getStreamVariable(\Smarty\Internal\Data $data, $variable)
    {
        $_result = '';
        $fp = fopen($variable, 'r+');
        if ($fp) {
            while (!feof($fp) && ($current_line = fgets($fp)) !== false) {
                $_result .= $current_line;
            }
            fclose($fp);
            return $_result;
        }
        $smarty = isset($data->smarty) ? $data->smarty : $data;
        if ($smarty->error_unassigned) {
            throw new \Smarty\Exception\SmartyException('Undefined stream variable "' . $variable . '"');
        } else {
            return null;
        }
    }
}
