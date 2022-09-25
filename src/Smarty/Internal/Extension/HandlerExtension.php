<?php

namespace Smarty\Internal\Extension;

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
 * @property   \Smarty\Internal\Runtime\CacheModifyRuntime       $_cacheModify
 * @property   \Smarty\Internal\Runtime\CacheResourceFileRuntime $_cacheResourceFile
 * @property   \Smarty\Internal\Runtime\CaptureRuntime           $_capture
 * @property   \Smarty\Internal\Runtime\CodeFrameRuntime         $_codeFrame
 * @property   \Smarty\Internal\Runtime\FilterHandlerRuntime     $_filterHandler
 * @property   \Smarty\Internal\Runtime\ForeachRuntime           $_foreach
 * @property   \Smarty\Internal\Runtime\GetIncludePathRuntime    $_getIncludePath
 * @property   \Smarty\Internal\Runtime\Make\NocacheMake      $_make_nocache
 * @property   \Smarty\Internal\Runtime\UpdateCacheRuntime       $_updateCache
 * @property   \Smarty\Internal\Runtime\UpdateScopeRuntime       $_updateScope
 * @property   \Smarty\Internal\Runtime\TplFunctionRuntime       $_tplFunction
 * @property   \Smarty\Internal\Runtime\WriteFileRuntime         $_writeFile
 *
 * Method extensions
 * @property   \Smarty\Internal\Method\GetTemplateVarsMethod    $getTemplateVars
 * @property   \Smarty\Internal\Method\AppendMethod             $append
 * @property   \Smarty\Internal\Method\AppendByRefMethod        $appendByRef
 * @property   \Smarty\Internal\Method\AssignGlobalMethod       $assignGlobal
 * @property   \Smarty\Internal\Method\AssignByRefMethod        $assignByRef
 * @property   \Smarty\Internal\Method\LoadFilterMethod         $loadFilter
 * @property   \Smarty\Internal\Method\LoadPluginMethod         $loadPlugin
 * @property   \Smarty\Internal\Method\RegisterFilterMethod     $registerFilter
 * @property   \Smarty\Internal\Method\RegisterObjectMethod     $registerObject
 * @property   \Smarty\Internal\Method\RegisterPluginMethod     $registerPlugin
 * @property   mixed|\Smarty\Template\CachedTemplate             configLoad
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
     * @param \Smarty\Internal\Data $data
     * @param string                $name external method names
     * @param array                 $args argument array
     *
     * @return mixed
     */
    public function _callExternalMethod(\Smarty\Internal\Data $data, $name, $args)
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
        return call_user_func_array(array(new \Smarty\Internal\Undefined(), $name), $args);
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
     * @return mixed|\Smarty\Template\CachedTemplate
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
            return $this->$property_name = new \Smarty\Internal\Undefined($class);
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
        return call_user_func_array(array(new \Smarty\Internal\Undefined(), $name), array($this));
    }
}
