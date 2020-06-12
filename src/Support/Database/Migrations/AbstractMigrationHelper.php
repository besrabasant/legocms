<?php

namespace LegoCMS\Support\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;

abstract class AbstractMigrationHelper
{
    protected static $instance;

    /**
     * Returns class instance.
     *
     * @return $this
     */
    protected static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    /**
     * Apply default Migration Columns
     *
     * @param  \Illuminate\Database\Schema\Blueprint $table
     *
     * @return void
     */
    abstract protected function apply(Blueprint $table);

    public function __call($method, $arguments)
    {
        if (\method_exists($this, $method)) {
            return $this->{$method}(...$arguments);
        } else {
            self::methodNotFoundException($method);
        }
    }

    public static function __callStatic($method, $arguments)
    {
        $instance = self::getInstance();

        if (\method_exists($instance, $method)) {
            return $instance->{$method}(...$arguments);
        } else {
            self::methodNotFoundException($method);
        }
    }

    /**
     * Throws Method not found Exception.
     *
     * @param string $method
     *
     * @throws \Throwable
     */
    protected static function methodNotFoundException($method)
    {
        throw new \BadMethodCallException("Method \"" . $method . "\" not found in \"" . static::class . "\"");
    }
}
