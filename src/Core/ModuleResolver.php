<?php

namespace LegoCMS\Core;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModuleResolver
{
    /** @var \Illuminate\Foundation\Application */
    protected $application;

    /**
     * __construct
     *
     * @param  \Illuminate\Foundation\Application $application
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application  = $application;
    }

    /**
     * resolve(): Resolves module from application container.
     *
     * @param  string $moduleName
     * @return \LegoCMS\Core\Module
     */
    public function resolve(string $moduleName)
    {
        return $this->application['legocms::module.' . $moduleName];
    }

    /**
     * resolveFromRequest(): Resolves module using the request parameter.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \LegoCMS\Core\Module
     */
    public function resolveFromRequest(Request $request = null)
    {
        $request = $request ?? $this->application['request'];
        $routeName = $request->route()->getName();
        $moduleName = explode(".", $routeName)[2];

        return $this->resolve(Str::singular($moduleName));
    }
}
