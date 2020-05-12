<?php

namespace LegoCMS\Core\Support;

abstract class BaseSkleton
{
    /**
     * Converts path to namespace.
     * eg:
     *  1) A/B/C => \A\B\C\
     *  2) A => \A\
     *
     * @param  string $namespace
     *
     * @return string
     */
    public function resolveNamespace(string $location)
    {
        return "\\" . str_replace("/", "\\", $location) . "\\";
    }

    /**
     * Chops the last part of the namespace.
     * eg: \A\B\C => \A\B
     *
     * @param  string $namespace
     *
     * @return bool|string
     */
    protected function oneLevelUp(string $namespace)
    {
        if ($pos = strrpos($namespace, '\\')) {
            return substr($namespace, 0, $pos);
        }

        return '';
    }
}
