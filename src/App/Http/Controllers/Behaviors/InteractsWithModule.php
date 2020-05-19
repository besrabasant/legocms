<?php

namespace LegoCMS\App\Http\Controllers\Behaviors;

use LegoCMS\Core\Support\Facades\ListingsView;

trait InteractsWithModule
{
    public function index()
    {
        /** @var \LegoCMS\Core\Module */
        $module = $this->resolve();

        return ListingsView::make($module->getListingsBuilder());
    }

    public function create()
    {
    }

    public function store()
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update($id)
    {
    }

    public function delete($id)
    {
    }

    public function forceDelete($id)
    {
    }

    public function bulkDelete()
    {
    }
}
