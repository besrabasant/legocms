<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use \Illuminate\Support\Str;

if (!function_exists('dumpUsableSqlQuery')) {
    function dumpUsableSqlQuery($query)
    {
        dd(\vsprintf(\str_replace('?', '%s', $query->toSql()), \array_map(function ($binding) {
            return \is_numeric($binding) ? $binding : "'{$binding}'";
        }, $query->getBindings())));
    }
}

if (!function_exists('classUsesDeep')) {
    /**
     * @param  mixed  $class
     * @param  bool  $autoload
     *
     * @return  array
     */
    function classUsesDeep($class, $autoload = true)
    {
        $traits = [];

        // Get traits of all parent classes
        do {
            $traits = \array_merge(\class_uses($class, $autoload), $traits);
        } while ($class = \get_parent_class($class));

        // Get traits of all parent traits
        $traitsToSearch = $traits;
        while (!empty($traitsToSearch)) {
            $newTraits = \class_uses(\array_pop($traitsToSearch), $autoload);
            $traits = \array_merge($newTraits, $traits);
            $traitsToSearch = \array_merge($newTraits, $traitsToSearch);
        }

        foreach ($traits as $trait => $same) {
            $traits = \array_merge(\class_uses($trait, $autoload), $traits);
        }

        return \array_unique($traits);
    }
}

if (!function_exists('classHasTrait')) {
    /**
     * @param  mixed $class
     * @param  string $trait
     *
     * @return  bool
     */
    function classHasTrait($class, $trait)
    {
        $traits = classUsesDeep($class);

        if (\in_array($trait, \array_keys($traits))) {
            return true;
        }

        return false;
    }
}

if (!function_exists('class_namespace')) {
    /**
     * Get the class "class_namespace" of the given object / class.
     *
     * @param  string|object  $class
     *
     * @return  string
     */
    function class_namespace($class)
    {
        $class = \is_object($class) ? \get_class($class) : $class;

        return \str_replace(\class_basename($class), '', $class);
    }
}


if (!function_exists('class_implements_interface')) {
    /**
     * Checks if a class implements a particular interface.
     *
     * @param  string|object  $class
     * @param  string  $interface
     *
     * @return  boolean
     */
    function class_implements_interface($class, $interface)
    {
        $class = \is_object($class) ? \get_class($class) : $class;

        $implementedInterfaces = \class_implements($class);

        return \in_array($interface, $implementedInterfaces);
    }
}


if (!function_exists('getFormFieldsValue')) {
    /**
     * @param  array  $formFields
     * @param  string  $name
     *
     * @return  mixed
     */
    function getFormFieldsValue($formFields, $name)
    {
        return Arr::get($formFields, \str_replace(']', '', \str_replace('[', '.', $name)), '');
    }
}

if (!function_exists('fireCmsEvent')) {
    /**
     * @param  string  $eventName
     * @param  array  $input
     *
     * @return  void
     */
    function fireCmsEvent($eventName, $input = [])
    {
        $method = method_exists(\Illuminate\Events\Dispatcher::class, 'dispatch') ? 'dispatch' : 'fire';
        Event::$method($eventName, [$eventName, $input]);
    }
}

if (!function_exists('legocms_path')) {
    /**
     * @param  string  $path
     *
     * @return  string
     */
    function legocms_path($path = '')
    {
        // Is it a full application path?
        if (Str::startsWith($path, base_path())) {
            return $path;
        }

        // Split to separate root namespace
        \preg_match('/(\w*)\W?(.*)/', config('legocms.namespace'), $namespaceParts);

        $legocmsBase = app_path(
            fix_directory_separator(
                $namespaceParts[1] == 'App' ? $namespaceParts[2] : $namespaceParts[0]
            )
        ) . '/';

        // Remove base path from path
        if (Str::startsWith($path, $legocmsBase)) {
            $path = Str::after($path, $legocmsBase);
        }

        // Namespace App is unchanged in config?
        if ($namespaceParts[0] === 'App') {
            return app_path($path);
        }

        // If it it still starts with App, use the left part, otherwise use the whole namespace
        // This can be a problem for those using a completely different app path for the application
        $left = ($namespaceParts[1] === 'App' ? $namespaceParts[2] : $namespaceParts[0]);

        // Join, fix slashes for the current operating system, and return path
        return app_path(fix_directory_separator(
            $left . (filled($path) ? '\\' . $path : '')
        ));
    }
}

if (!function_exists('make_legocms_directory')) {
    /**
     * @param  string  $path
     * @param  bool  $recursive
     * @param  \Illuminate\Filesystem\Filesystem|null  $fs
     *
     * @return void
     */
    function make_legocms_directory($path, $recursive = true, $fs = null)
    {
        $fs = filled($fs)
            ? $fs
            : app(Filesystem::class);

        $path = legocms_path($path);

        if (!$fs->isDirectory($path)) {
            $fs->makeDirectory($path, 0755, $recursive);
        }
    }
}

if (!function_exists('legocms_put_stub')) {
    /**
     * @param  string  $path
     * @param  bool  $recursive
     * @param  \Illuminate\Filesystem\Filesystem|null  $fs
     *
     * @return void
     */
    function legocms_put_stub($path, $stub, $fs = null)
    {
        $fs = filled($fs)
            ? $fs
            : app(Filesystem::class);

        $stub = \str_replace(
            'namespace App\\',
            \sprintf('namespace %s\\', config('legocms.namespace')),
            $stub
        );

        if (!$fs->exists($path)) {
            $fs->put($path, $stub);
        }
    }
}

if (!function_exists('fix_directory_separator')) {
    /**
     * @param  string  $path
     * @param  bool  $recursive
     * @param  int  $mode
     *
     * @return  string
     */
    function fix_directory_separator($path)
    {
        return \str_replace(
            '\\',
            DIRECTORY_SEPARATOR,
            $path
        );
    }
}
