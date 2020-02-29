<?php

namespace LegoCMS\Services\View;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class AbstractService
 *
 * @package LegoCMS\Services\View
 * @category Services
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Services/View/AbstractService.php
 */
abstract class AbstractService
{
    /**
     * $app
     *
     * @var  Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * $request
     *
     * @var  Illuminate\Http\Request;
     */
    protected $request;

    /**
     * Attributes.
     *
     * @var  array
     */
    protected $attributes = [];

    /**
     * Route Name Parts.
     *
     * @var array
     */
    protected $routeNameParts = [];

    /**
     * $moduleName
     *
     * @var  string
     */
    protected $moduleName = null;




    /**
     * __construct
     *
     * @param  Illuminate\Foundation\Application  $app
     *
     * @return  void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->request = $app['request'];

        $this->configureRouteParts();
    }


    /**
     * Configure Route Name Parts as array.
     *
     * @return void
     */
    private function configureRouteParts()
    {
        if ($this->request->route()) {
            $routeName = $this->request->route()->getName();

            $this->routeNameParts = \explode('.', $routeName);
        }
    }

    /**
     * Returns Current Route Action.
     *
     * @return void
     */
    public function getCurrentAction()
    {
        return last($this->routeNameParts);
    }


    /**
     * Sets Default Attributes.
     *
     * @param  array  $attributes
     *
     * @return  void
     */
    public function setDefaults($attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);
    }

    /**
     * Sets Attribute.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return  void
     */
    protected function setAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;
    }

    /**
     * Gets Attribute value.
     *
     * @param  string  $attribute
     * @param  mixed  $defaultValue
     *
     * @return  mixed
     */
    protected function getAttribute($attribute, $defaultValue = null)
    {
        if (!array_key_exists($attribute, $this->attributes)) {
            return $defaultValue;
        }

        return $this->attributes[$attribute];
    }


    /**
     * Returns Module Name,
     *
     * @return  string
     */
    public function getModuleName($raw = false)
    {
        $moduleName = $this->moduleName ? $this->moduleNam : $this->routeNameParts[1];

        if ($raw) {
            return $moduleName;
        }

        return \str_replace("-", " ", $moduleName);
    }

    /**
     * Returns Singular Module Name,
     *
     * @return  void
     */
    public function getModuleNameSingular()
    {
        return Str::singular($this->getModuleName());
    }

    /**
     * Sets Module Name.
     *
     * @param  string  $moduleName
     *
     * @return  void
     */
    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;
    }

    /**
     * Get attribute name.
     *
     * @param  string  $name
     * @param  string  $modifier
     *
     * @return  void
     */
    protected function attributeName($name, $modifier)
    {
        return Str::snake(str_replace($modifier, "", $name));
    }

    /**
     * Delegates calls to functions.
     *
     * @param  string  $name
     * @param  mixed  $arguments
     *
     * @return  mixed
     */
    public function __call($name, $arguments)
    {
        if (Str::startsWith($name, 'set')) {
            $this->setAttribute($this->attributeName($name, 'set'), $arguments);
        }

        if (Str::startsWith($name, 'get')) {
            return $this->getAttribute($this->attributeName($name, 'get'), $arguments);
        }
    }
}
