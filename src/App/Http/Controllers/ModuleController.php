<?php

namespace LegoCMS\App\Http\Controllers;

use Illuminate\Http\Request;
use LegoCMS\App\Http\Controllers\Behaviors\InteractsWithModule;
use LegoCMS\App\Http\Controllers\Behaviors\ResolvesModule;

abstract class ModuleController extends Controller
{
    use InteractsWithModule, ResolvesModule;

    /** @var Request */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
