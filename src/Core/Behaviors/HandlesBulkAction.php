<?php

namespace LegoCMS\Core\Behaviors;

trait HandlesBulkAction
{
    public function handleBulk($request, $models, $params = null)
    {
        $models->each(function ($model) use ($request, $params) {
            return $this->handle($request, $model, $params);
        });
    }
}
