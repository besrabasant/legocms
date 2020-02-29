<?php

namespace LegoCMS\Services;

use Illuminate\Support\Str;

/**
 * class LegoSet
 *
 * @package  LegoCMS\Services
 * @category Services
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Services/LegoSet.php
 *
 * @method string getNamespace()
 * @method bool hasNamespace()
 * @method string getPackageRoot()
 * @method bool hasPackageRoot()
 * @method string getRoutesDir()
 * @method bool hasRoutesDir()
 */
class LegoSet
{
    /**
     * config
     *
     * @var  mixed
     */
    private $config;

    /**
     * __construct
     *
     * @param  array  $legoSetConfig
     *
     * @return  void
     */
    public function __construct(array $legoSetConfig)
    {
        $this->config = $legoSetConfig;
    }

    /**
     * Delegates method call to get attribute value from the config.
     *
     * @param  string  $name
     * @param  mixed  $arguments
     *
     * @return  string|bool
     */
    public function __call($name, $arguments)
    {
        if (Str::startsWith($name, 'has')) {
            return $this->checkIfKeyExists(
                $this->getKeyName($name, 'has')
            );
        } elseif (Str::startsWith($name, 'get')) {
            try {
                return $this->config[$this->getKeyName($name, 'get')];
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    /**
     * Checks if key exists in config.
     *
     * @param  string  $key
     *
     * @return  bool
     */
    private function checkIfKeyExists($key)
    {
        return \array_key_exists($key, $this->config);
    }

    /**
     * Returns actual key name.
     *
     * @param  string  $name
     * @param  string  $replaceable
     *
     * @return  void
     */
    private function getKeyName($name, $replaceable)
    {
        return (string) Str::of($name)->replaceFirst($replaceable, '')->snake();
    }
}
