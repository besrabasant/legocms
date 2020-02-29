<?php

namespace LegoCMS\Support\Macros;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

/**
 * Class RouteModuleMacro.
 *
 * @mixin    \Illuminate\Routing\Router
 * @category Macros
 * @package  LegoCMS\Support\Macros
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Support/Macros/RouteModuleMacro.php
 */
class RouteModuleMacro
{
    /**
     * __invoke
     *
     * @return \Closure
     */
    public function __invoke()
    {
        /**
         * @param  string  $slug
         * @param  array  $options
         * @param  array  $resource_options
         * @param  bool  $resource
         *
         * @mixin \Illuminate\Routing\Router
         *
         * @return  void
         */
        return function (string $slug, array $options = [], array $resource_options = [], bool $resource = true) {

            $slugs = \explode('.', $slug);

            $prefixSlug = \str_replace('.', "/", $slug);

            $slugBase = Arr::last($slugs);

            $className =  \implode("", \array_map(function ($slug) {
                return Str::singular(Str::studly($slug));
            }, $slugs));

            $additionalRoutes = $defaults = [
                'reorder', 'tags', 'preview', 'browser', 'duplicate',
                'publish', 'bulkPublish',
                'feature', 'bulkFeature',
                'restore', 'bulkRestore',
                'forceDelete', 'bulkForceDelete', 'bulkDelete',
                'restoreRevision', 'previewRevision', 'deleteRevision'
            ];

            if (isset($options['only'])) {
                $additionalRoutes = \array_intersect($defaults, (array) $options['only']);
            } elseif (isset($options['except'])) {
                $additionalRoutes = \array_diff($defaults, (array) $options['except']);
            }

            $groupPrefix = \trim(\str_replace('/', '.', Route::getLastGroupPrefix()), '.');

            if (!empty($admin_app_path = \config('legocms.admin_app_path'))) {
                $groupPrefix = \ltrim(
                    \str_replace(
                        $admin_app_path,
                        '',
                        $groupPrefix
                    ),
                    '.'
                );
            }

            $additionalRoutesPrefix = !empty($groupPrefix) ? "{$groupPrefix}.{$slug}" : "{$slug}";

            foreach ($additionalRoutes as $route) {
                $routeParam = "/{" . Str::singular($slugBase) . "}";
                $routeName = $additionalRoutesPrefix . ".{$route}";

                $mapping = [
                    'as' => $routeName,
                    'uses' => "{$className}Controller@{$route}"
                ];

                if (\in_array($route, ['previewRevision'])) {
                    $routeSlug = "{$prefixSlug}{$routeParam}/revision/{revision}";
                    Route::get($routeSlug, $mapping);
                }

                if (\in_array($route, ['restoreRevision'])) {
                    $routeSlug = "{$prefixSlug}{$routeParam}/revision/{revision}";
                    Route::put($routeSlug, $mapping);
                }

                if (\in_array($route, ['deleteRevision'])) {
                    $routeSlug = "{$prefixSlug}{$routeParam}/revision/{revision}";
                    Route::delete($routeSlug, $mapping);
                }

                if (\in_array($route, ['publish', 'feature', 'restore', 'forceDelete'])) {
                    $routeSlug = "{$prefixSlug}{$routeParam}/" . Str::kebab($route);
                    Route::put($routeSlug, $mapping);
                }

                if (in_array($route, ['preview'])) {
                    $routeSlug = "{$prefixSlug}{$routeParam}/" . Str::kebab($route);
                    Route::get($routeSlug, $mapping);
                }
            }


            if ($resource) {
                Route::resource($slug, "{$className}Controller", $resource_options);
            }
        };
    }
}
