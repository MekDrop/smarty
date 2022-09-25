<?php

namespace Smarty\Internal\Extension;

use Smarty\Internal\Data;
use Smarty\Internal\Method\AppendByRefMethod;
use Smarty\Internal\Method\AppendMethod;
use Smarty\Internal\Method\AssignByRefMethod;
use Smarty\Internal\Method\AssignGlobalMethod;
use Smarty\Internal\Method\GetTemplateVarsMethod;
use Smarty\Internal\Method\LoadFilterMethod;
use Smarty\Internal\Method\LoadPluginMethod;
use Smarty\Internal\Method\RegisterFilterMethod;
use Smarty\Internal\Method\RegisterObjectMethod;
use Smarty\Internal\Method\RegisterPluginMethod;
use Smarty\Internal\Runtime\CacheModifyRuntime;
use Smarty\Internal\Runtime\CacheResourceFileRuntime;
use Smarty\Internal\Runtime\CaptureRuntime;
use Smarty\Internal\Runtime\CodeFrameRuntime;
use Smarty\Internal\Runtime\FilterHandlerRuntime;
use Smarty\Internal\Runtime\ForeachRuntime;
use Smarty\Internal\Runtime\GetIncludePathRuntime;
use Smarty\Internal\Runtime\Make\NocacheMake;
use Smarty\Internal\Runtime\TplFunctionRuntime;
use Smarty\Internal\Runtime\UpdateCacheRuntime;
use Smarty\Internal\Runtime\UpdateScopeRuntime;
use Smarty\Internal\Runtime\WriteFileRuntime;
use Smarty\Internal\Undefined;
use Smarty\Template\CachedTemplate;

/**
 * Smarty Extension handler
 *
 * Load extensions dynamically
 *
 * @package    Smarty
 * @subpackage PluginsInternal
 * @author     Uwe Tews
 *
 * Runtime extensions
 * @property   CacheModifyRuntime       $_cacheModify
 * @property   CacheResourceFileRuntime $_cacheResourceFile
 * @property   CaptureRuntime           $_capture
 * @property   CodeFrameRuntime         $_codeFrame
 * @property   FilterHandlerRuntime     $_filterHandler
 * @property   ForeachRuntime           $_foreach
 * @property   GetIncludePathRuntime    $_getIncludePath
 * @property   NocacheMake      $_make_nocache
 * @property   UpdateCacheRuntime       $_updateCache
 * @property   UpdateScopeRuntime       $_updateScope
 * @property   TplFunctionRuntime       $_tplFunction
 * @property   WriteFileRuntime         $_writeFile
 *
 * Method extensions
 * @property   GetTemplateVarsMethod    $getTemplateVars
 * @property   AppendMethod             $append
 * @property   AppendByRefMethod        $appendByRef
 * @property   AssignGlobalMethod       $assignGlobal
 * @property   AssignByRefMethod        $assignByRef
 * @property   LoadFilterMethod         $loadFilter
 * @property   LoadPluginMethod         $loadPlugin
 * @property   RegisterFilterMethod     $registerFilter
 * @property   RegisterObjectMethod     $registerObject
 * @property   RegisterPluginMethod     $registerPlugin
 * @property   mixed|CachedTemplate             configLoad
 */
class HandlerExtension
{
    public $objType = null;

    /**
     * Cache for property information from generic getter/setter
     * Preloaded with names which should not use with generic getter/setter
     *
     * @var array
     */
    private $_property_info     = array(
        'AutoloadFilters' => 0, 'DefaultModifiers' => 0, 'ConfigVars' => 0,
        'DebugTemplate'   => 0, 'RegisteredObject' => 0, 'StreamVariable' => 0,
        'TemplateVars'    => 0, 'Literals' => 'Literals',
    );//

    private $resolvedProperties = array();

    /**
     * Call external Method
     *
     * @param Data $data
     * @param string                $name external method names
     * @param array                 $args argument array
     *
     * @return mixed
     */
    public function _callExternalMethod(Data $data, $name, $args)
    {
        /* @var \Smarty $data ->smarty */
        $smarty = isset($data->smarty) ? $data->smarty : $data;
        if (!isset($smarty->ext->$name)) {
            if (preg_match('/^((set|get)|(.*?))([A-Z].*)$/', $name, $match)) {
                $basename = $this->upperCase($match[ 4 ]);
                if (!isset($smarty->ext->$basename) && isset($this->_property_info[ $basename ])
                    && is_string($this->_property_info[ $basename ])
                ) {
                    $class = '\\Smarty\\Internal\\Method\\' . $this->_property_info[ $basename ];
                    if (class_exists($class)) {
                        $classObj = new $class();
                        $methodes = get_class_methods($classObj);
                        foreach ($methodes as $method) {
                            $smarty->ext->$method = $classObj;
                        }
                    }
                }
                if (!empty($match[ 2 ]) && !isset($smarty->ext->$name)) {
                    $class = '\\Smarty\\Internal\\Method\\' . $this->upperCase($name);
                    if (!class_exists($class)) {
                        $objType = $data->_objType;
                        $propertyType = false;
                        if (!isset($this->resolvedProperties[ $match[ 0 ] ][ $objType ])) {
                            $property = $this->resolvedProperties['property'][$basename] ??
                                $this->resolvedProperties['property'][$basename] = smarty_strtolower_ascii(
                                join(
                                    '_',
                                    preg_split(
                                        '/([A-Z][^A-Z]*)/',
                                        $basename,
                                        -1,
                                        PREG_SPLIT_NO_EMPTY |
                                        PREG_SPLIT_DELIM_CAPTURE
                                    )
                                )
                            );
                            if ($property !== false) {
                                if (property_exists($data, $property)) {
                                    $propertyType = $this->resolvedProperties[ $match[ 0 ] ][ $objType ] = 1;
                                } elseif (property_exists($smarty, $property)) {
                                    $propertyType = $this->resolvedProperties[ $match[ 0 ] ][ $objType ] = 2;
                                } else {
                                    $this->resolvedProperties[ 'property' ][ $basename ] = $property = false;
                                }
                            }
                        } else {
                            $propertyType = $this->resolvedProperties[ $match[ 0 ] ][ $objType ];
                            $property = $this->resolvedProperties[ 'property' ][ $basename ];
                        }
                        if ($propertyType) {
                            $obj = $propertyType === 1 ? $data : $smarty;
                            if ($match[ 2 ] === 'get') {
                                return $obj->$property;
                            } elseif ($match[ 2 ] === 'set') {
                                return $obj->$property = $args[ 0 ];
                            }
                        }
                    }
                }
            }
        }
        $callback = array($smarty->ext->$name, $name);
        array_unshift($args, $data);
        if (isset($callback) && $callback[ 0 ]->objMap | $data->_objType) {
            return call_user_func_array($callback, $args);
        }
        return call_user_func_array(array(new Undefined(), $name), $args);
    }

    /**
     * Make first character of name parts upper case
     *
     * @param string $name
     *
     * @return string
     */
    public function upperCase($name)
    {
        $_name = explode('_', $name);
        $_name = array_map('smarty_ucfirst_ascii', $_name);
        return implode('_', $_name);
    }

    /**
     * get extension object
     *
     * @param string $property_name property name
     *
     * @return mixed|CachedTemplate
     */
    public function __get($property_name)
    {
        // object properties of runtime template extensions will start with '_'
        if ($property_name[ 0 ] === '_') {
            $class = '\\Smarty\\Internal\\Runtime' . $this->upperCase($property_name);
        } else {
            $class = '\\Smarty\\Internal\\Method\\' . $this->upperCase($property_name);
        }
        if (!class_exists($class)) {
            return $this->$property_name = new Undefined($class);
        }
        return $this->$property_name = new $class();
    }

    /**
     * set extension property
     *
     * @param string $property_name property name
     * @param mixed  $value         value
     *
     */
    public function __set($property_name, $value)
    {
        $this->$property_name = $value;
    }

    /**
     * Call error handler for undefined method
     *
     * @param string $name unknown method-name
     * @param array  $args argument array
     *
     * @return mixed
     */
    public function __call($name, $args)
    {
        return call_user_func_array(array(new Undefined(), $name), array($this));
    }
}
