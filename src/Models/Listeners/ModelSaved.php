<?php

namespace LegoCMS\Models\Listeners;

class ModelSaved
{
    protected $model;
    /**
     * __construct
     *
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function handle()
    {
        dd($this->model);
    }
}
