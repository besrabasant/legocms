<?php

namespace LegoCMS\Core;

use Illuminate\Foundation\Application;

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

    public function load(string $moduleclass)
    {
    }

    public function loadFrom(string $moduleDir)
    {
    }
}
