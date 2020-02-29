<?php

if (!function_exists('moduleRoute')) {

    /**
     * Returns Module route.
     *
     * @param  string  $moduleName
     * @param  string  $action
     * @param  array  $parameters
     * @param  string  $prefix
     *
     * @return  void
     */
    function moduleRoute(
        string $moduleName,
        string $action = 'index',
        array $parameters = [],
        string $prefix = 'legocms'
    ) {
        $moduleName = \str_replace('_', '-', $moduleName);
        return \route("{$prefix}.{$moduleName}.{$action}", $parameters);
    }
}
