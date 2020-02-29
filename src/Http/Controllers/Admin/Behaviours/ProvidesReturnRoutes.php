<?php

namespace LegoCMS\Http\Controllers\Admin\Behaviours;

trait ProvidesReturnRoutes
{
    /**
     * ReturnToIndexRoute
     *
     * @return RedirectResponse
     */
    public function returnToIndexRoute()
    {
        return \redirect()->to(\moduleRoute($this->getModuleName()));
    }

    /**
     * Return To Edit Route
     *
     * @param  mixed $params
     *
     * @return RedirectResponse
     */
    public function returnToEditRoute($params)
    {
        return \redirect()->to(\moduleRoute(
            $this->getModuleName(),
            'edit',
            $params
        ));
    }
}
